<?php

namespace Plane\Shop;

use InvalidArgumentException;

/**
 * Collecion of CartItem objects
 *
 * @author Dariusz Korsak <dkorsak@gmail.com>
 * $package Plane/Shop
 */
class CartItemCollection
{
    /**
     * Array of \Plane\Shop\CartItemInterface object
     * @var array
     */
    private $items = [];

    /**
     * Add item to collection
     * @param \Plane\Shop\CartItemInterface $obj
     * @param int|string $key
     * @throws \InvalidArgumentException
     */
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

    /**
     * Remove item from collection
     * @param int|string $key
     * @throws \InvalidArgumentException
     */
    public function deleteItem($key)
    {
        if (!array_key_exists($key, $this->items)) {
            throw new InvalidArgumentException("Invalid key $key.");
        }

        unset($this->items[$key]);
    }

    /**
     * Return item from collection
     * @param int|string $key
     * @return \Plane\Shop\CartItemInterface
     * @throws \InvalidArgumentException
     */
    public function getItem($key)
    {
        if (!array_key_exists($key, $this->items)) {
            throw new InvalidArgumentException("Invalid key $key.");
        }
        
        return $this->items[$key];
    }
    
    /**
     * Replace item
     * @param \Plane\Shop\CartItemInterface $obj
     * @param int|string $key
     */
    public function replaceItem(CartItemInterface $obj, $key)
    {
        $this->items[$key] = $obj;
    }
            
    /**
     * Return all items
     * @return array
     */
    public function getItems()
    {
        return $this->items;
    }
    
    /**
     * Return items keys
     * @return array
     */
    public function keys()
    {
        return array_keys($this->items);
    }
    
    /**
     * Check if item key exists
     * @param int|string $key
     * @return boolean
     */
    public function keyExists($key)
    {
        return array_key_exists($key, $this->items);
    }
            
    /**
     * Return number of items
     * @return int
     */
    public function length()
    {
        return count($this->items);
    }
}
