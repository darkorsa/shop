<?php

namespace Plane\Shop;

use DomainException;
use Plane\Shop\CartItemInterface as CartItem;

/**
 * Shopcart class
 *
 * @author Dariusz Korsak <dkorsak@gmail.com>
 * @package Plane\Shop
 */
class Cart implements CartInterface
{
    protected $items = [];
    
    public function add(CartItem $item)
    {
        // if product already in the cart, increase quantity
        if ($this->has($item)) {
            $this->get($item->getId())->increaseQuantity($item->getQuantity());
            return;
        }
        
        $this->items[$item->getId()] = $item;
    }
    
    public function remove($itemId)
    {
        if (!$this->has($itemId)) {
            throw new DomainException('Item ' . $itemId . ' not found');
        }
        
        unset($this->items[$itemId]);
    }
      
    public function update(Product $item)
    {
        $this->items[$item->getId()] = $item;
    }
    
    public function has($itemId)
    {
        return array_key_exists($itemId, $this->items);
    }
    
    public function get($itemId)
    {
        if (!$this->has($itemId)) {
            throw new DomainException('Item ' . $itemId . ' not found');
        }
        
        return $this->items[$itemId];
    }
    
    public function all()
    {
        return $this->items;
    }
    
    public function clear()
    {
        $this->items = [];
    }
    
    public function totalItems()
    {
        return array_sum(
            array_map(function (CartItem $item) {
                return $item->getQuantity();
            }, $this->items)
        );
    }
    
    public function total()
    {
        return (float) array_sum(
            array_map(function (PriceInterface $item) {
                return $item->getPriceTotal();
            }, $this->items)
        );
    }
    
    public function totalWithTax()
    {
        return (float) array_sum(
            array_map(function (PriceInterface $item) {
                return $item->getPriceTotalWithTax();
            }, $this->items)
        );
    }

    public function totalTax()
    {
        return (float) array_sum(
            array_map(function (PriceInterface $item) {
                return $item->getTaxTotal();
            }, $this->items)
        );
    }
}
