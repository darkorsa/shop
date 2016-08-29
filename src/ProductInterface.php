<?php

namespace Plane\Shop;

/**
 * Interface for Product class
 * 
 * @author Dariusz Korsak <dkorsak@gmail.com>
 * @package Plane\Shop
 */
interface ProductInterface 
{
    public function getId();
    
    public function getName();

    public function getPrice();

    public function getImagePath();
    
    public function getTaxRate();
}
