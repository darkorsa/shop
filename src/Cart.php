<?php

namespace Plane\Shop;

use DomainException;
use Plane\Shop\CartDiscount;
use Plane\Shop\CartItemInterface;
use Plane\Shop\CartItemCollection;
use Plane\Shop\PaymentInterface;
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
    private $items = [];
    
    private $priceFormat;
    
    private $shipping;
    
    private $payment;
    
    private $discounts = [];
    
    public function __construct(PriceFormatInterface $priceFormat = null)
    {
        $this->priceFormat = $priceFormat;
    }
    
    public function setShipping(ShippingInterface $shipping)
    {
        $this->shipping = $shipping;
        $this->shipping->setPriceFormat($this->priceFormat);
    }
    
    public function setPayment(PaymentInterface $payment)
    {
        $this->payment = $payment;
        $this->payment->setPriceFormat($this->priceFormat);
    }
    
    public function addDiscount(CartDiscount $discount)
    {
        $discount->setPriceFormat($this->priceFormat);
        $this->discounts[] = $discount;
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
    
    public function total()
    {
        return (float) array_sum(
            array_map(function (CartItemInterface $item) {
                return $item->getPriceTotalWithTax();
            }, $this->items)
        );
    }
    
    public function totalItems()
    {
        return array_sum(
            array_map(function (CartItemInterface $item) {
                return $item->getQuantity();
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
    
    public function totalAfterDisconuts()
    {
        return (float) array_sum(
            array_map(function (CartDiscount $discount) {
                return $discount->getPriceAfterDiscount();
            }, $this->discounts)
        );
    }
    
    public function shippingCost()
    {
        return $this->shipping->getCost();
    }
    
    public function paymentFee()
    {
        return $this->payment->getFee();
    }
        
    public function toArray()
    {
        $array = [];
        /*$array['items'] = array_map(function (CartItemInterface $item) {
            return $item->toArray();
        }, $this->items);*/
        
        $array['shipping']['name']      = $this->shipping->getName();
        $array['shipping']['desc']      = $this->shipping->getDescription();
        $array['shipping']['cost']      = $this->shippingCost();
        
        $array['payment']['name']       = $this->payment->getName();
        $array['payment']['desc']       = $this->payment->getDescription();
        $array['payment']['fee']        = $this->paymentFee();
        
        $array['discounts'] = array_map(function (CartDiscount $discount) {
            return [
                'text'  => $discount->getDiscountText(),
                'price' => $discount->getPriceAfterDiscount()
            ];
        }, $this->discounts);
        
        $array['totalItems']        = $this->totalItems();
        $array['total']             = $this->total();
        $array['totalTax']          = $this->totalTax();
        $array['shippingCost']      = $this->shippingCost();
        $array['paymentFee']        = $this->paymentFee();
        
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
