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

use OutOfBoundsException;
use Money\MoneyFormatter;
use Money\Currencies\ISOCurrencies;
use Money\Formatter\DecimalMoneyFormatter;

class Cart implements CartInterface
{
    private $items = [];
    
    private $priceFormat;
    
    private $shipping;
    
    private $payment;
    
    private $discounts = [];
    
    public function __construct(MoneyFormatter $priceFormat = null)
    {
        $this->priceFormat = $priceFormat ?: new DecimalMoneyFormatter(new ISOCurrencies());
    }

    public function setShipping(ShippingInterface $shipping): void
    {
        $this->shipping = $shipping;
    }
    
    public function getShipping(): ShippingInterface
    {
        return $this->shipping;
    }
    
    public function setPayment(PaymentInterface $payment): void
    {
        $this->payment = $payment;
    }
    
    public function getPayment(): PaymentInterface
    {
        return $this->payment;
    }
    
    public function addDiscount(CartDiscount $discount): void
    {
        $discount->setPriceFormat($this->priceFormat);
        $this->discounts[] = $discount;
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
    
    public function remove(int $itemId): void
    {
        if (!$this->has($itemId)) {
            throw new OutOfBoundsException('Item ' . $itemId . ' not found');
        }
        
        unset($this->items[$itemId]);
    }
      
    public function update(CartItemInterface $item): void
    {
        $this->addItem($item);
    }
    
    public function has(int $itemId): bool
    {
        return array_key_exists($itemId, $this->items);
    }

    public function get(int $itemId): CartItemInterface
    {
        if (!$this->has($itemId)) {
            throw new OutOfBoundsException('Item ' . $itemId . ' not found');
        }
        
        return $this->items[$itemId];
    }
    
    public function all(): array
    {
        return $this->items;
    }
    
    public function clear(): void
    {
        $this->items = [];
    }

    public function total(): float
    {
        return (float) array_sum(
            array_map(function (CartItemInterface $item) {
                return $item->getPriceTotalWithTax();
            }, $this->items)
        );
    }
    
    public function totalItems(): int
    {
        return array_sum(
            array_map(function (CartItemInterface $item) {
                return $item->getQuantity();
            }, $this->items)
        );
    }
    
    public function totalTax(): float
    {
        return (float) array_sum(
            array_map(function (CartItemInterface $item) {
                return $item->getTaxTotal();
            }, $this->items)
        );
    }
    
    public function totalWeight(): float
    {
        return (float) array_sum(
            array_map(function (CartItemInterface $item) {
                return $item->getWeightTotal();
            }, $this->items)
        );
    }
    
    public function totalAfterDiscounts(): float
    {
        return !empty($this->discounts)
            ? (float) end($this->discounts)->getPriceAfterDiscount()
            : $this->total();
    }

    public function shippingCost(): float
    {
        if (!is_object($this->shipping)) {
            return null;
        }
        
        return $this->shipping->getCost();
    }
    
    public function paymentFee(): float
    {
        if (!is_object($this->payment)) {
            return null;
        }
        
        return $this->payment->getFee($this->totalAfterDiscounts() + (float) $this->shippingCost());
    }
        
    public function toArray(): array
    {
        $array = [];
        $array['items'] = array_map(function (CartItemInterface $item) {
            return $item->toArray();
        }, $this->items);
        
        
        if (!is_null($this->shipping)) {
            $array['shipping']['name']      = $this->shipping->getName();
            $array['shipping']['desc']      = $this->shipping->getDescription();
            $array['shipping']['cost']      = $this->shippingCost();
        }
        
        if (!is_null($this->payment)) {
            $array['payment']['name']       = $this->payment->getName();
            $array['payment']['desc']       = $this->payment->getDescription();
            $array['payment']['fee']        = $this->paymentFee();
        }
        
        $array['discounts'] = array_map(function (CartDiscount $discount) {
            return [
                'text'  => $discount->getDiscountText(),
                'price' => $discount->getPriceAfterDiscount()
            ];
        }, $this->discounts);
        
        $array['totalItems']        = $this->totalItems();
        $array['total']             = $this->total();
        $array['totalTax']          = $this->totalTax();
        $array['totalWeight']       = $this->totalWeight();
        $array['shippingCost']      = $this->shippingCost();
        $array['paymentFee']        = $this->paymentFee();
        $array['totalAfterDiscounts'] = $this->totalAfterDiscounts();
        
        return $array;
    }
    
    private function addItem(CartItemInterface $item)
    {
        // override item's price format in order to make it consistent with cart's price format
        if (!is_null($this->priceFormat)) {
            $item->setPriceFormat($this->priceFormat);
        }
        
        $this->items[$item->getId()] = $item;
    }
}
