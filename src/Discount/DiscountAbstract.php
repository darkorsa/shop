<?php

namespace Plane\Shop\Discount;

use Plane\Shop\CartDiscount;
use Plane\Shop\CartInterface;
use Plane\Shop\Discount\DiscountInterface;

/**
 * Abstract class for discounts
 *
 * @author Dariusz Korsak <dkorsak@gmail.com>
 * @package Plane\Shop
 */
abstract class DiscountAbstract implements DiscountInterface
{
    /**
     * Discount name
     * @var string
     */
    protected $name;
    
    /**
     * Discount description
     * @var string
     */
    protected $description;
    
    /**
     * Cart object
     * @var \Plane\Shop\CartInterface
     */
    protected $cart;
    
    /**
     * Cart discount object
     * @var \Plane\Shop\CartDiscount
     */
    protected $cartDiscount;
    
    /**
     * Constructor
     * @param \Plane\Shop\CartInterface $cart
     * @param array $config
     */
    public function __construct(CartInterface $cart, array $config)
    {
        $this->cart = $cart;
        $this->cartDiscount = new CartDiscount();
        
        foreach ($config as $k => $v) {
            $this->$k = $v;
        }
        
        $this->applyDiscount();
    }
    
    /**
     * Set CartDiscount object
     * @param \Plane\Shop\CartDiscount $cartDiscount
     */
    public function setCartDiscount(CartDiscount $cartDiscount)
    {
        $this->cartDiscount = $cartDiscount;
    }
    
    /**
     * Return name
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
    
    /**
     * Return description
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }
    
    /**
     * Apply discount
     */
    abstract protected function applyDiscount();
}
