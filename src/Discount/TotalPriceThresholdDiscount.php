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
    
    /**
     * Price treshiold
     * @var int
     */
    protected $threshold;
    
    /**
     * Discount value
     * @var float
     */
    protected $discount;
    
    /**
     * Apply discount so that after total price is over given treshold
     */
    protected function applyDiscount()
    {
        $total = $this->totalAfterDiscounts();
        
        if ($total >= $this->threshold) {
            $total = $total - ($total * $this->discount);
        }
                
        $this->cartDiscount->setDiscountText($this->description);
        $this->cartDiscount->setPriceAfterDiscount($total);
        
        $this->addDiscount($this->cartDiscount);
    }
}
