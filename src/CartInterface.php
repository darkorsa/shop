<?php

namespace Plane\Shop;

use Plane\Shop\CartItemInterface;

/**
 * Interface for Cart classes
 *
 * @author Dariusz Korsak <dkorsak@gmail.com>
 * @package Plane\Shop;
 */
interface CartInterface
{
    public function setShipping(ShippingInterface $shipping);
    
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
    
    public function shippingCost();
    
    public function toArray();
}
