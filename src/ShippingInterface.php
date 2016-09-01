<?php

namespace Plane\Shop;

/**
 * Interface for shipping classes
 *
 * @author Dariusz Korsak <dkorsak@gmail.com>
 * @package Plane\Shop
 */
interface ShippingInterface
{
    public function getId();
    
    public function getName();
    
    public function getDescription();
    
    public function getCost();
}
