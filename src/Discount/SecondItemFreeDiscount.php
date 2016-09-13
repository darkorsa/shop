<?php

namespace Plane\Shop\Discount;

use Plane\Shop\CartInterface;

/**
 * Description of SecondItemFreeDiscount
 *
 * @author Dariusz Korsak <dkorsak@gmail.com>
 * @package Plane\Shop;
 */
class SecondItemFreeDiscount extends DiscountAbstract implements CartInterface
{
    use \Plane\Shop\CartDecoratorTrait;
    
    protected function applyDiscount()
    {
        $total = $this->totalAfterDisconuts();

        $i = 1;
        foreach ($this->all() as $item) {
            // every even item is free
            if ($i % 2 == 0) {
                $total -= $item->getPriceTotalWithTax();
            }
            $i++;
        }
        
        $this->cartDiscount->setDiscountText($this->description);
        $this->cartDiscount->setPriceAfterDiscount($total);
        
        $this->addDiscount($this->cartDiscount);
    }
    
}
