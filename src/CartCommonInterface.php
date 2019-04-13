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

interface CartCommonInterface
{
    public function getCurrency(): string;
    
    public function setShipping(ShippingInterface $shipping): void;
    
    public function getShipping(): ?ShippingInterface;
    
    public function setPayment(PaymentInterface $payment) : void;
    
    public function getPayment(): ?PaymentInterface;
    
    public function addDiscount(CartDiscountInterface $discount): void;

    public function getDiscounts(): array;
    
    public function fill(CartItemCollection $collection): void;
    
    public function add(CartItemInterface $item): void;
    
    public function remove(string $itemId): void;

    public function clear(): void;
    
    public function update(CartItemInterface $item): void;
    
    public function has(string $itemId): bool;
    
    public function get(string $itemId): CartItemInterface;
    
    public function items(): array;

    public function itemsQuantity(): int;

    public function weight(): string;
}
