<?php declare(strict_types=1);

/*
 * This file is part of the Plane\Shop package.
 *
 * (c) Dariusz Korsak <dkorsak@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Plane\Shop\Traits;

use Plane\Shop\PaymentInterface;
use Plane\Shop\CartItemInterface;
use Plane\Shop\ShippingInterface;
use Plane\Shop\CartItemCollection;
use Plane\Shop\CartDiscountInterface;

trait CartCommon
{
    public function getCurrency(): string
    {
        return $this->cart->getCurrency();
    }

    public function setShipping(ShippingInterface $shipping): void
    {
        $this->cart->setShipping($shipping);
    }
    
    public function getShipping(): ?ShippingInterface
    {
        return $this->cart->getShipping();
    }
    
    public function setPayment(PaymentInterface $payment): void
    {
        $this->cart->setPayment($payment);
    }
    
    public function getPayment(): ?PaymentInterface
    {
        return $this->cart->getPayment();
    }
    
    public function addDiscount(CartDiscountInterface $discount): void
    {
        $this->cart->addDiscount($discount);
    }

    public function getDiscounts(): array
    {
        return $this->cart->getDiscounts();
    }

    public function fill(CartItemCollection $collection): void
    {
        $this->cart->fill($collection);
    }
    
    public function add(CartItemInterface $item): void
    {
        $this->cart->add($item);
    }
    
    public function remove(string $itemId): void
    {
        $this->cart->remove($itemId);
    }

    public function clear(): void
    {
        $this->cart->clear();
    }

    public function update(CartItemInterface $item): void
    {
        $this->cart->update($item);
    }
    
    public function has(string $itemId): bool
    {
        return $this->cart->has($itemId);
    }
    
    public function get(string $itemId): CartItemInterface
    {
        return $this->cart->get($itemId);
    }
    
    public function items(): array
    {
        return $this->cart->items();
    }
    
    public function itemsQuantity(): int
    {
        return $this->cart->itemsQuantity();
    }
    
    public function weight(): string
    {
        return $this->cart->weight();
    }
}
