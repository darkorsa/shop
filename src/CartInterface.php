<?php

namespace Plane\Shop;

use Plane\Shop\CartDiscount;
use Plane\Shop\CartItemInterface;
use Plane\Shop\PaymentInterface;
use Plane\Shop\ShippingInterface;

/**
 * Interface for Cart classes
 *
 * @author Dariusz Korsak <dkorsak@gmail.com>
 * @package Plane\Shop;
 */
interface CartInterface
{
    public function setShipping(ShippingInterface $shipping);
    
    public function setPayment(PaymentInterface $payment);
    
    public function addDiscount(CartDiscount $discount);
    
    public function fill(CartItemCollection $collection);
    
    public function add(CartItemInterface $item);
    
    public function remove($itemId);
    
    public function update(Product $item);
    
    public function has($itemId);
    
    public function get($itemId);
    
    public function all();
    
    public function clear();
    
    public function totalItems();
    
    public function total();

    public function totalTax();
    
    public function totalAfterDisconuts();
    
    public function shippingCost();
    
    public function paymentFee();
    
    public function toArray();
}
