<?php

namespace Plane\Shop;

use Plane\Shop\PriceFormat\PriceFormatInterface;

/**
 * Interface for shipping classes
 *
 * @author Dariusz Korsak <dkorsak@gmail.com>
 * @package Plane\Shop
 */
interface ShippingInterface
{
    /**
     * Return id
     * @return int
     */
    public function getId();
    
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
    
    /**
     * Return cost
     * @return float
     */
    public function getCost();
    
    /**
     * Set cost
     * @param int|float $cost
     */
    public function setCost($cost);
    
    /**
     * Set price format object
     * @param \Plane\Shop\PriceFormat\PriceFormatInterface $priceFormat
     */
    public function setPriceFormat(PriceFormatInterface $priceFormat);
}
