<?php

namespace Plane\Shop\Discount;

use Plane\Shop\CartDiscount;
use Plane\Shop\CartInterface;
use Plane\Shop\Discount\DiscountInterface;

/**
 * Description of DiscountAbstract
 *
 * @author Dariusz Korsak <leonardo@codeninjas.pl>
 * @package Plane\Shop
 */
abstract class DiscountAbstract implements DiscountInterface
{
    protected $name;
    
    protected $description;
    
    protected $cart;
    
    protected $cartDiscount;
    
    public function __construct(CartInterface $cart, array $config)
    {
        $this->cart = $cart;
        $this->cartDiscount = new CartDiscount();
        
        foreach ($config as $k => $v) {
            $this->$k = $v;
        }
        
        $this->applyDiscount();
    }
    
    public function setCartDiscount(CartDiscount $cartDiscount)
    {
        $this->cartDisconut = $cartDiscount;
    }
    
    public function getName()
    {
        return $this->name;
    }
    
    public function getDesc()
    {
        return $this->description;
    }
    
    abstract protected function applyDiscount();
}
