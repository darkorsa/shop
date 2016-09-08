<?php

namespace Plane\Shop\Discount;

use Plane\Shop\CartInterface;
use Plane\Shop\CartDiscount;
use Plane\Shop\Discount\DiscountInterface;

/**
 * Description of SecondItemFreeDiscount
 *
 * @author Dariusz Korsak <dkorsak@gmail.com>
 * @package Plane\Shop;
 */
class TotalPriceThresholdDiscount implements CartInterface, DiscountInterface
{
    use \Plane\Shop\CartDecoratorTrait;
    
    private $name;
    
    private $description;
    
    private $cartDiscount;
    
    private $threshold;
    
    private $discount;
    
    public function __construct(CartInterface $cart, CartDiscount $cartDiscount, array $config)
    {
        $this->cart = $cart;
        $this->cartDiscount = $cartDiscount;
        
        foreach ($config as $k => $v) {
            $this->$k = $v;
        }
        
        $this->applyDiscount();
    }
    
    public function getName()
    {
        return $this->name;
    }
    
    public function getDesc()
    {
        return $this->description;
    }
    
    private function applyDiscount()
    {
        $total = $this->totalAfterDisconuts();
        
        if ($total >= $this->threshold) {
            $discountedPrice = $total - ($total * $this->discount);
        }
                
        $this->cartDiscount->setDiscountTest($this->description);
        $this->cartDiscount->setPriceAfterDiscount($discountedPrice);
        
        $this->addDiscount($this->cartDiscount);
    }
    
}
