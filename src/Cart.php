<?php declare(strict_types=1);

/*
 * This file is part of the Plane\Shop package.
 *
 * (c) Dariusz Korsak <dkorsak@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Plane\Shop;

use Money\Money;
use Money\Currency;
use OutOfBoundsException;
use Plane\Shop\CartDiscount;
use Plane\Shop\PaymentInterface;
use Plane\Shop\CartItemInterface;
use Plane\Shop\ShippingInterface;
use Plane\Shop\CartItemCollection;

final class Cart implements CartInterface
{
    private $items = [];

    private $currency;
    
    private $shipping;
    
    private $payment;
    
    private $discounts = [];
    
    public function __construct(string $currency)
    {
        $this->currency = $currency;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function setShipping(ShippingInterface $shipping): void
    {
        $this->shipping = $shipping;
    }
    
    public function getShipping(): ?ShippingInterface
    {
        return $this->shipping;
    }
    
    public function setPayment(PaymentInterface $payment): void
    {
        $this->payment = $payment;
    }
    
    public function getPayment(): ?PaymentInterface
    {
        return $this->payment;
    }
    
    public function addDiscount(CartDiscount $discount): void
    {
        $this->discounts[] = $discount;
    }

    public function getDiscounts(): array
    {
        return $this->discounts;
    }
    
    public function fill(CartItemCollection $collection): void
    {
        array_map(function ($item) {
            $this->addItem($item);
        }, $collection->getItems());
    }

    public function add(CartItemInterface $item): void
    {
        // if product already in the cart, increase quantity
        if ($this->has($item->getId())) {
            $this->get($item->getId())->increaseQuantity($item->getQuantity());
            return;
        }
        
        $this->addItem($item);
    }
    
    public function remove(string $itemId): void
    {
        if (!$this->has($itemId)) {
            throw new OutOfBoundsException('Item ' . $itemId . ' not found');
        }
        
        unset($this->items[$itemId]);
    }

    public function clear(): void
    {
        $this->items = [];
    }
      
    public function update(CartItemInterface $item): void
    {
        $this->addItem($item);
    }
    
    public function has(string $itemId): bool
    {
        return array_key_exists($itemId, $this->items);
    }

    public function get(string $itemId): CartItemInterface
    {
        if (!$this->has($itemId)) {
            throw new OutOfBoundsException('Item ' . $itemId . ' not found');
        }
        
        return $this->items[$itemId];
    }
    
    public function items(): array
    {
        return $this->items;
    }
    
    public function itemsQuantity(): int
    {
        return (int) array_sum(
            array_map(function (CartItemInterface $item) {
                return $item->getQuantity();
            }, $this->items)
        );
    }

    public function weight(): string
    {
        return (string) array_sum(
            array_map(function (CartItemInterface $item) {
                return $item->getWeightTotal();
            }, $this->items)
        );
    }

    public function totalNet(): Money
    {
        $total = array_map(function (CartItemInterface $item) {
            return $item->getPriceTotal($this->currency);
        }, $this->items);
        
        return $this->sumPrices($total);
    }

    public function totalGross(): Money
    {
        $total = array_map(function (CartItemInterface $item) {
            return $item->getPriceTotalWithTax($this->currency);
        }, $this->items);
        
        return $this->sumPrices($total);
    }
    
    public function tax(): Money
    {
        $total = array_map(function (CartItemInterface $item) {
            return $item->getTaxTotal($this->currency);
        }, $this->items);

        return $this->sumPrices($total);
    }
    
    public function totalAfterDiscounts(): Money
    {
        return !empty($this->discounts)
            ? end($this->discounts)->getPriceAfterDiscount()
            : $this->totalGross();
    }

    public function shippingCost(): Money
    {
        if (!$this->shipping instanceof ShippingInterface) {
            return new Money(0, new Currency($this->currency));
        }
        
        return $this->shipping->getCost($this->currency);
    }
    
    public function paymentFee(): Money
    {
        if (!$this->payment instanceof PaymentInterface) {
            return new Money(0, new Currency($this->currency));
        }

        return $this->payment->getFee($this->totalAfterDiscounts()->add($this->shippingCost()), $this->currency);
    }
    
    private function addItem(CartItemInterface $item)
    {
        $this->items[$item->getId()] = $item;
    }

    private function sumPrices(array $prices): Money
    {
        $money = new Money(0, new Currency($this->currency));

        return call_user_func_array([$money, 'add'], $prices);
    }
}
