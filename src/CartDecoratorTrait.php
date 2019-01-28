<?php

/*
 * This file is part of the Plane\Shop package.
 *
 * (c) Dariusz Korsak <dkorsak@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Plane\Shop;

trait CartDecoratorTrait
{
    protected $cart;
    
    public function setShipping(ShippingInterface $shipping): void
    {
        $this->cart->setShipping($shipping);
    }
    
    public function getShipping(): ShippingInterface
    {
        return $this->cart->getShipping();
    }
    
    public function setPayment(PaymentInterface $payment): void
    {
        $this->cart->setPayment($payment);
    }
    
    public function getPayment(): PaymentInterface
    {
        return $this->cart->getPayment();
    }
    
    public function addDiscount(CartDiscount $discount): void
    {
        $this->cart->addDiscount($discount);
    }

    public function fill(CartItemCollection $collection): void
    {
        $this->cart->fill($collection);
    }
    
    public function add(CartItemInterface $item): void
    {
        $this->cart->add($item);
    }
    
    public function remove($itemId): void
    {
        $this->cart->remove($itemId);
    }

    public function update(CartItemInterface $item): void
    {
        $this->cart->update($item);
    }
    
    public function has($itemId): bool
    {
        return $this->cart->has($itemId);
    }
    
    public function get($itemId): CartItemInterface
    {
        return $this->cart->get($itemId);
    }
    
    public function all(): array
    {
        return $this->cart->all();
    }
    
    public function clear(): void
    {
        $this->cart->clear();
    }
    
    public function total(): float
    {
        return $this->cart->total();
    }
    
    public function totalItems(): int
    {
        return $this->cart->totalItems();
    }

    public function totalTax(): float
    {
        return $this->cart->totalTax();
    }
    
    public function totalWeight(): float
    {
        return $this->cart->totalWeight();
    }
    
    public function totalAfterDiscounts(): float
    {
        return $this->cart->totalAfterDiscounts();
    }

    public function shippingCost(): float
    {
        return $this->cart->shippingCost();
    }
    
    public function paymentFee(): float
    {
        return $this->cart->paymentFee();
    }
    
    public function toArray(): array
    {
        return $this->cart->toArray();
    }
}
