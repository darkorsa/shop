<?php

namespace Plane\Shop\Discount;

use Plane\Shop\CartInterface;

/**
 * Description of SecondItemFreeDiscount
 *
 * @author Dariusz Korsak <dkorsak@gmail.com>
 * @package Plane\Shop;
 */
class SecondItemFreeDiscount implements CartInterface
{
    use \Plane\Shop\CartDecoratorTrait;
    
    private $name;
    
    private $description;
    
    public function __construct(CartInterface $cart)
    {
        $this->cart = $cart;
        
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
        $items = $this->all();
        
        $i = 1;
        foreach ($items as $item) {
            // every even item is free
            if ($i % 2 == 0) {
                $item->setPrice(0);
            }
            $i++;
        }
    }
    
}
