<?php

/*
 * This file is part of the Plane\Shop package.
 *
 * (c) Dariusz Korsak <dkorsak@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Plane\Shop\Discount;

use Plane\Shop\CartInterface;
use Plane\Shop\CartDecoratorTrait;

class SecondItemFreeDiscount extends DiscountAbstract implements CartInterface
{
    use CartDecoratorTrait;
    
    /**
     * Apply discount so that every even item price is set to 0
     */
    protected function applyDiscount()
    {
        $total = $this->totalAfterDiscounts();

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
