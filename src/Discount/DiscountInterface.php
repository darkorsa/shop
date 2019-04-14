<?php

namespace Plane\Shop\Discount;

use Plane\Shop\CartDiscount;

/**
 * Inferface for discount classes
 *
 * @author Dariusz Korsak <dkorsak@gmail.com>
 * @package Plane\Shop
 */
interface DiscountInterface
{
    /**
     * Set CartDiscount object
     * @param \Plane\Shop\CartDiscount $cartDiscount
     */
    public function setCartDiscount(CartDiscount $cartDiscount);
    
    /**
     * Return name
     * @return string
     */
    public function getName();
    
    /**
     * Return description
     * @return string
     */
    public function getDescription();
}
