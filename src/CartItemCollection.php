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

use OutOfBoundsException;
use InvalidArgumentException;

class CartItemCollection
{
    private $items = [];

    public function addItem(CartItemInterface $obj, $key = null)
    {
        if ($key == null) {
            $this->items[] = $obj;
        } else {
            if (array_key_exists($key, $this->items)) {
                throw new InvalidArgumentException("Key $key already in use.");
            }
           
            $this->items[$key] = $obj;
        }
    }

    public function deleteItem($key)
    {
        if (!array_key_exists($key, $this->items)) {
            throw new OutOfBoundsException("Invalid key $key.");
        }

        unset($this->items[$key]);
    }

    public function getItem($key)
    {
        if (!array_key_exists($key, $this->items)) {
            throw new OutOfBoundsException("Invalid key $key.");
        }
        
        return $this->items[$key];
    }
    
    public function replaceItem(CartItemInterface $obj, $key)
    {
        $this->items[$key] = $obj;
    }
            
    public function getItems()
    {
        return $this->items;
    }
    
    public function keys()
    {
        return array_keys($this->items);
    }
    
    public function keyExists($key)
    {
        return array_key_exists($key, $this->items);
    }
            
    public function length()
    {
        return count($this->items);
    }
}
