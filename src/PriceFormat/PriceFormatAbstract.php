<?php

namespace Plane\Shop\PriceFormat;

use Plane\Shop\CartItemInterface;

/**
 * Abstract class for price format
 *
 * @author Dariusz Korsak <dkorsak@gmail.com>
 * @package Plane\Shop;
 */
abstract class PriceFormatAbstract implements CartItemInterface
{
    protected $cartItem;
    
    public function __construct(CartItemInterface $cartItem)
    {
        $this->cartItem = $cartItem;
    }
    
    public function getId()
    {
        return  $this->cartItem->getId();
    }
        
    public function getName()
    {
        return  $this->cartItem->getName();
    }
    
    public function getImagePath()
    {
        return  $this->cartItem->getImagePath();
    }
    
    public function getQuantity()
    {
        return  $this->cartItem->getQuantity();
    }
    
    public function setQuantity($quantity)
    {
        $this->cartItem->setQuantity($quantity);
    }
    
    public function increaseQuantity($quantity)
    {
        $this->cartItem->increaseQuantity($quantity);
    }
    
    public function decreaseQuantity($quantity)
    {
        $this->cartItem->decreaseQuantity($quantity);
    }
    
    public function getTax()
    {
        return $this->formatPrice($this->cartItem->getTax());
    }
    
    public function getTaxTotal()
    {
        return $this->formatPrice($this->cartItem->getTaxTotal());
    }
    
    public function getPrice()
    {
        return $this->formatPrice($this->cartItem->getPrice());
    }
    
    public function getPriceWithTax()
    {
        return $this->formatPrice($this->cartItem->getPriceWithTax());
    }
    
    public function getPriceTotal()
    {
        return $this->formatPrice($this->cartItem->getPriceTotal());
    }
    
    public function getPriceTotalWithTax()
    {
        return $this->formatPrice($this->cartItem->getPriceTotalWithTax());
    }
    
    abstract protected function formatPrice($price);
}
