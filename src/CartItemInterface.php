<?php

namespace Plane\Shop;

use Plane\Shop\PriceFormat\PriceFormatInterface;

/**
 * Description of CartItem
 *
 * @author Dariusz Korsak <dkorsak@gmail.com>
 * @package Plane\Shop
 */
interface CartItemInterface
{
    /**
     * Return product object
     * @return \Plane\Shop\ProductInterface
     */
    public function getProduct();
    
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
     * Return cart item quantity
     * @return int
     */
    public function getQuantity();
    
     /**
     * Return cart item quantity
     * @return int
     */
    public function getImagePath();
    
    /**
     * Set cart item quantity
     * @param int $quantity
     * @throws \DomainException
     */
    public function setQuantity($quantity);
    
    /**
     * Increase cart item quantity
     * @param int $quantity
     */
    public function increaseQuantity($quantity);
    
    /**
     * Decrease cart item quantity
     * @param int $quantity
     */
    public function decreaseQuantity($quantity);
    
    /**
     * Return tax for single item
     * @return float
     */
    public function getTax();
    
    /**
     * Return tax for all items
     * @return float
     */
    public function getTaxTotal();
    
    /**
     * Return product weight
     * @return float
     */
    public function getWeight();
    
    /**
     * Return weight for all items
     * @return float
     */
    public function getWeightTotal();
    
    /**
     * Return single cart item price
     * @return float
     */
    public function getPrice();
    
    /**
     * Set price for item
     * @param float $price
     */
    public function setPrice($price);
    
    /**
     * Return price for all items
     * @return float
     */
    public function getPriceTotal();
    
    /**
     * Return price including tax for single item
     * @return float
     */
    public function getPriceWithTax();
    
    /**
     * Return price including tax for all items
     * @return float
     */
    public function getPriceTotalWithTax();
    
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
