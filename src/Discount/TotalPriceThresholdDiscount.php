<?php

namespace Plane\Shop\Discount;

use Plane\Shop\CartInterface;

/**
 * Description of SecondItemFreeDiscount
 *
 * @author Dariusz Korsak <dkorsak@gmail.com>
 * @package Plane\Shop;
 */
class TotalPriceThresholdDiscount extends DiscountAbstract implements CartInterface
{
    use \Plane\Shop\CartDecoratorTrait;
    
    protected $threshold;
    
    protected $discount;
    
    protected function applyDiscount()
    {
        $total = $this->totalAfterDisconuts();
        
        if ($total >= $this->threshold) {
            $total = $total - ($total * $this->discount);
        }
                
        $this->cartDiscount->setDiscountText($this->description);
        $this->cartDiscount->setPriceAfterDiscount($total);
        
        $this->addDiscount($this->cartDiscount);
    }
    
}
