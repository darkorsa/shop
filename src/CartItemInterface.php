<?php

namespace Plane\Shop;

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
}
