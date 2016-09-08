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
class SecondItemFreeDiscount implements CartInterface, DiscountInterface
{
    use \Plane\Shop\CartDecoratorTrait;
    
    private $name;
    
    private $description;
    
    private $cartDiscount;
    
    public function __construct(CartInterface $cart, CartDiscount $cartDiscount)
    {
        $this->cart = $cart;
        $this->cartDiscount = $cartDiscount;
        
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
        $discountedPrice = 0;
        
        $items = $this->all();
        
        $i = 1;
        foreach ($items as $item) {
            // every even item is free
            if ($i % 2 == 0) {
                continue;
            }
            $discountedPrice += $item->getPriceTotalWithTax();
            $i++;
        }
        
        $this->cartDiscount->setDiscountTest($this->description);
        $this->cartDiscount->setPriceAfterDiscount($discountedPrice);
        
        $this->addDiscount($this->cartDiscount);
    }
    
}
