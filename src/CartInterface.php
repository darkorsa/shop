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

interface CartInterface
{
    public function setShipping(ShippingInterface $shipping): void;
    
    public function getShipping(): ShippingInterface;
    
    public function setPayment(PaymentInterface $payment) : void;
    
    public function getPayment(): PaymentInterface;
    
    public function addDiscount(CartDiscount $discount): void;
    
    public function fill(CartItemCollection $collection): void;
    
    public function add(CartItemInterface $item): void;
    
    public function remove(int $itemId): void;
    
    public function update(CartItemInterface $item): void;
    
    public function has(int $itemId): bool;
    
    public function get(int $itemId): CartItemInterface;
    
    public function all(): array;
    
    public function clear(): void;
    
    public function total(): float;
    
    public function totalItems(): int;
    
    public function totalTax(): float;
    
    public function totalWeight(): float;
    
    public function totalAfterDiscounts(): float;
    
    public function shippingCost(): float;
    
    public function paymentFee(): float;
    
    public function toArray(): array;
}
