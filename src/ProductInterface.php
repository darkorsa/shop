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
    /**
     * Return id
     * @return ing
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
}
