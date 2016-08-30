<?php

namespace Plane\Shop\Discount;

/**
 * NullDiscount class when no discount is applicable
 *
 * @author Dariusz Korsak <dkorsak@gmail.com>
 * @package Plane\Shop
 */
class NullDiscount
{
    protected $product;
    
    protected $quantity;

    public function __construct()
    {
        
    }
}
