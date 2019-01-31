<?php declare(strict_types=1);

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
use Plane\Shop\DiscountAbstract;
use Plane\Shop\CartCommonDecorator;
use Plane\Shop\CartPricesDecorator;

class EverySecondItemFreeDiscount extends DiscountAbstract implements CartInterface
{
    use CartCommonDecorator;
    use CartPricesDecorator;
    
    /**
     * Apply discount so that every even item price is set to 0
     */
    protected function applyDiscount(): void
    {
        $total = $this->totalAfterDiscounts();
        $subctracts = [];

        $i = 1;
        foreach ($this->items() as $item) {
            // every even item is free
            if ($i % 2 == 0) {
                $subctracts[] = $item->getPriceTotalWithTax($this->getCurrency());
            }
            $i++;
        }

        $afterDiscount = call_user_func_array([$total, 'subtract'], $subctracts);
        
        $this->cartDiscount->setPriceAfterDiscount($afterDiscount);
        
        $this->addDiscount($this->cartDiscount);
    }
}
