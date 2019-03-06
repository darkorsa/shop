<?php declare(strict_types=1);

/*
 * This file is part of the Plane\Shop package.
 *
 * (c) Dariusz Korsak <dkorsak@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Plane\Shop;

class CartItemCollection
{
    private $items = [];

    public function addItem(CartItemInterface $cartItem)
    {
        $this->items[] = $cartItem;
    }

    public function getItems()
    {
        return $this->items;
    }
    
    public function length()
    {
        return count($this->items);
    }
}
