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
    public function getId();
        
    public function getName();
    
    public function getQuantity();
    
    public function getImagePath();
    
    public function setQuantity($quantity);
    
    public function increaseQuantity($quantity);
    
    public function decreaseQuantity($quantity);
    
    public function getTax();
    
    public function getTaxTotal();
    
    public function getPrice();
    
    public function setPrice($price);
    
    public function getPriceTotal();
    
    public function getPriceWithTax();
    
    public function getPriceTotalWithTax();
    
    public function setPriceFormat(PriceFormatInterface $priceFormat);
    
    public function toArray();
}
