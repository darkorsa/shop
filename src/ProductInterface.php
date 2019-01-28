<?php

namespace Plane\Shop;

use Plane\Shop\PriceFormat\PriceFormatInterface;

/**
 * Interface for Product class
 *
 * @author Dariusz Korsak <dkorsak@gmail.com>
 * @package Plane\Shop
 */
interface ProductInterface
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
     * Return price
     * @return float
     */
    public function getPrice();
    
    /**
     * Return weight
     * @return float
     */
    public function getWeight();
    
    /**
     * Set price
     * @param int|float $price
     */
    public function setPrice($price);

    /**
     * Return image path
     * @return string
     */
    public function getImagePath();
    
    /**
     * Return tax rate
     * @return float
     */
    public function getTaxRate();
    
    /**
     * Return tax for single item
     * @return float
     */
    public function getTax();
    
    /**
     * Return price including tax for single item
     * @return float
     */
    public function getPriceWithTax();
    
    /**
     * Set price format object
     * @param \Plane\Shop\PriceFormat\PriceFormatInterface $priceFormat
     */
    public function setPriceFormat(PriceFormatInterface $priceFormat);
    
    /**
     * Return object array representation
     * @return array
     */
    public function toArray();
}
