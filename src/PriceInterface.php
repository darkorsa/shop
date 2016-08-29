<?php

namespace Plane\Shop;

/**
 * Interface for price related classes
 * 
 * @author Dariusz Korsak <dkorsak@gmail.com>
 * @package Plane\Shop
 */
interface PriceInterface
{
    public function getTax();
    
    public function getTaxTotal();
    
    public function getPrice();
    
    public function getPriceWithTax();
    
    public function getPriceTotal();
    
    public function getPriceTotalWithTax();
    
}
