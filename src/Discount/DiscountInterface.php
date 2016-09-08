<?php

namespace Plane\Shop\Discount;

/**
 * Inferface for discount classes
 *
 * @author Dariusz Korsak <dkorsak@gmail.com>
 * @package Plane\Shop
 */
interface DiscountInterface
{
    public function getName();
    
    public function getDesc();
}
