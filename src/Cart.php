<?php

namespace Plane\Shop;

use DomainException;
use Plane\Shop\CartItemInterface;
use Plane\Shop\CartItemCollection;
use Plane\Shop\ShippingInterface;
use Plane\Shop\PriceFormat\PriceFormatInterface;

/**
 * Shopping cart class
 *
 * @author Dariusz Korsak <dkorsak@gmail.com>
 * @package Plane\Shop
 */
class Cart implements CartInterface
{
    protected $items = [];
    
    protected $priceFormat;
    
    protected $shipping;
    
    public function __construct(PriceFormatInterface $priceFormat = null)
    {
        $this->priceFormat = $priceFormat;
    }
    
    public function setShipping(ShippingInterface $shipping)
    {
        $this->shipping = $shipping;
    }
    
    public function fill(CartItemCollection $collection)
    {
        array_map(function ($item) {
            $this->addItem($item);
        }, $collection->getItems());
    }
    
    public function add(CartItemInterface $item)
    {
        // if product already in the cart, increase quantity
        if ($this->has($item->getId())) {
            $this->get($item->getId())->increaseQuantity($item->getQuantity());
            return;
        }
        
        $this->addItem($item);
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
        $this->addItem($item);
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
            array_map(function (CartItemInterface $item) {
                return $item->getQuantity();
            }, $this->items)
        );
    }
    
    public function totalWithoutTax()
    {
        return (float) array_sum(
            array_map(function (CartItemInterface $item) {
                return $item->getPriceTotal();
            }, $this->items)
        );
    }
    
    public function total()
    {
        return (float) array_sum(
            array_map(function (CartItemInterface $item) {
                return $item->getPriceTotalWithTax();
            }, $this->items)
        );
    }

    public function totalTax()
    {
        return (float) array_sum(
            array_map(function (CartItemInterface $item) {
                return $item->getTaxTotal();
            }, $this->items)
        );
    }
    
    public function totalWithShipping()
    {
        return $this->priceFormat->formatPrice($this->total() + (float) $this->shipping->getCost());
    }
    
    public function shippingCost()
    {
        return $this->priceFormat->formatPrice($this->shipping->getCost());
    }
        
    public function toArray()
    {
        $array = [];
        $array['items'] = array_map(function (CartItemInterface $item) {
            return $item->toArray();
        }, $this->items);
        
        $array['shipping_name']     = $this->shipping->getName();
        $array['shipping_desc']     = $this->shipping->getDescription();
        $array['shipping_cost']     = $this->shippingCost();
        
        $array['totalItems']        = $this->totalItems();
        $array['total']             = $this->total();
        $array['totalWithoutTax']   = $this->totalWithoutTax();
        $array['totalTax']          = $this->totalTax();
        $array['totalWithShipping'] = $this->totalWithShipping();
        
        return $array;
    }
    
    protected function addItem(CartItemInterface $item)
    {
        // override item's price format in order to make it consistent with cart's price format
        if (!is_null($this->priceFormat)) {
            $item->setPriceFormat($this->priceFormat);
        }
        
        $this->items[$item->getId()] = $item;
    }
}
