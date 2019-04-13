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

use Plane\Shop\CartDiscountAbstract;

class EverySecondItemFreeDiscount extends CartDiscountAbstract
{
    protected $items;
    
    /**
     * Apply discount so that every even item price is set to 0
     */
    protected function applyDiscount(): void
    {
        $subctracts = [];
        $i = 1;
        foreach ($this->items as $item) {
            // every even item is free
            if ($i % 2 == 0) {
                $subctracts[] = $item->getPriceTotalWithTax($this->currency);
            }
            $i++;
        }

        $afterDiscount = call_user_func_array([$this->price, 'subtract'], $subctracts);

        $this->priceAfterDiscount = $afterDiscount;
    }
}
