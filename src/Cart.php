<?php

namespace Plane\Shop;

use DomainException;
use Plane\Shop\PriceFormat\PriceFormatInterface;

/**
 * Shopping cart class
 *
 * @author Dariusz Korsak <dkorsak@gmail.com>
 * @package Plane\Shop
 */
class Cart implements CartInterface
{
    /**
     * Array of cart item objects
     * @var array
     */
    private $items = [];
    
    /**
     * Price formatting object
     * @var \Plane\Shop\PriceFormat\PriceFormatInterface
     */
    private $priceFormat;
    
    /**
     * Shipping object
     * @var \Plane\Shop\ShippingInterface
     */
    private $shipping;
    
    /**
     * Payment object
     * @var \Plane\Shop\PaymentInterface
     */
    private $payment;
    
    /**
     * Array of discount objects
     * @var array
     */
    private $discounts = [];
    
    /**
     * Object constructor
     * @param \Plane\Shop\PriceFormatInterface $priceFormat
     */
    public function __construct(PriceFormatInterface $priceFormat = null)
    {
        $this->priceFormat = $priceFormat;
    }
    
    /**
     * Set shipping object
     * @param \Plane\Shop\ShippingInterface $shipping
     */
    public function setShipping(ShippingInterface $shipping)
    {
        $this->shipping = $shipping;
        $this->shipping->setPriceFormat($this->priceFormat);
    }
    
    /**
     * Return shipping object
     * @return \Plane\Shop\ShippingInterface
     */
    public function getShipping()
    {
        return $this->shipping;
    }
    
    /**
     * Set payment object
     * @param \Plane\Shop\PaymentInterface $payment
     */
    public function setPayment(PaymentInterface $payment)
    {
        $this->payment = $payment;
        $this->payment->setPriceFormat($this->priceFormat);
    }
    
    /**
     * Return payment object
     * @return \Plane\Shop\PaymentInterface
     */
    public function getPayment()
    {
        return $this->payment;
    }
    
    /**
     * Add discount
     * @param \Plane\Shop\CartDiscount $discount
     */
    public function addDiscount(CartDiscount $discount)
    {
        $discount->setPriceFormat($this->priceFormat);
        $this->discounts[] = $discount;
    }
    
    /**
     * Fill cart with items
     * @param \Plane\Shop\CartItemCollection $collection
     */
    public function fill(CartItemCollection $collection)
    {
        array_map(function ($item) {
            $this->addItem($item);
        }, $collection->getItems());
    }
    
    /**
     * Add cart item
     * @param \Plane\Shop\CartItemInterface $item
     */
    public function add(CartItemInterface $item)
    {
        // if product already in the cart, increase quantity
        if ($this->has($item->getId())) {
            $this->get($item->getId())->increaseQuantity($item->getQuantity());
            return;
        }
        
        $this->addItem($item);
    }
    
    /**
     * Remove cart item
     * @param int $itemId
     * @throws \DomainException
     */
    public function remove($itemId)
    {
        if (!$this->has($itemId)) {
            throw new DomainException('Item ' . $itemId . ' not found');
        }
        
        unset($this->items[$itemId]);
    }
      
    /**
     * Replace cart item
     * @param \Plane\Shop\CartItemInterface $item
     */
    public function update(CartItemInterface $item)
    {
        $this->addItem($item);
    }
    
    /**
     * Check if cart item with given id exists
     * @param int $itemId
     * @return boolean
     */
    public function has($itemId)
    {
        return array_key_exists($itemId, $this->items);
    }
    
    /**
     * Return cart item object
     * @param int $itemId
     * @return \Plane\Shop\CartItemInterface
     * @throws \DomainException
     */
    public function get($itemId)
    {
        if (!$this->has($itemId)) {
            throw new DomainException('Item ' . $itemId . ' not found');
        }
        
        return $this->items[$itemId];
    }
    
    /**
     * Return array of cart items
     * @return array
     */
    public function all()
    {
        return $this->items;
    }
    
    /**
     * Remove all cart items
     */
    public function clear()
    {
        $this->items = [];
    }
    
    /**
     * Return sum of cart items prices with tax
     * @return float
     */
    public function total()
    {
        return (float) array_sum(
            array_map(function (CartItemInterface $item) {
                return $item->getPriceTotalWithTax();
            }, $this->items)
        );
    }
    
    /**
     * Return number of cart items
     * @return int
     */
    public function totalItems()
    {
        return array_sum(
            array_map(function (CartItemInterface $item) {
                return $item->getQuantity();
            }, $this->items)
        );
    }
    
    /**
     * Return sum of cart items tax
     * @return float
     */
    public function totalTax()
    {
        return (float) array_sum(
            array_map(function (CartItemInterface $item) {
                return $item->getTaxTotal();
            }, $this->items)
        );
    }
    
    /**
     * Return total weight of all items
     * return float
     */
    public function totalWeight()
    {
        return (float) array_sum(
            array_map(function (CartItemInterface $item) {
                return $item->getWeightTotal();
            }, $this->items)
        );
    }
    
    /**
     * Return price after discounts
     * @return float
     */
    public function totalAfterDisconuts()
    {
        return !empty($this->discounts)
            ? end($this->discounts)->getPriceAfterDiscount()
            : $this->total();
                
    }
    
    /**
     * Return shipping cost
     * @return float
     */
    public function shippingCost()
    {
        if (!is_object($this->shipping)) {
            return null;
        }
        
        return $this->shipping->getCost();
    }
    
    /**
     * Return payment fee
     * @return float
     */
    public function paymentFee()
    {
        if (!is_object($this->payment)) {
            return null;
        }
        
        return $this->payment->getFee();
    }
        
    /**
     * Cast object to array
     * @return array
     */
    public function toArray()
    {
        $array = [];
        $array['items'] = array_map(function (CartItemInterface $item) {
            return $item->toArray();
        }, $this->items);
        
        
        if (!is_null($this->shipping)) {
            $array['shipping']['name']      = $this->shipping->getName();
            $array['shipping']['desc']      = $this->shipping->getDescription();
            $array['shipping']['cost']      = $this->shippingCost();
        }
        
        if (!is_null($this->payment)) {
            $array['payment']['name']       = $this->payment->getName();
            $array['payment']['desc']       = $this->payment->getDescription();
            $array['payment']['fee']        = $this->paymentFee();
        }
        
        $array['discounts'] = array_map(function (CartDiscount $discount) {
            return [
                'text'  => $discount->getDiscountText(),
                'price' => $discount->getPriceAfterDiscount()
            ];
        }, $this->discounts);
        
        $array['totalItems']        = $this->totalItems();
        $array['total']             = $this->total();
        $array['totalTax']          = $this->totalTax();
        $array['totalWeight']       = $this->totalWeight();
        $array['shippingCost']      = $this->shippingCost();
        $array['paymentFee']        = $this->paymentFee();
        $array['totalAfterDisconuts'] = $this->totalAfterDisconuts();
        
        return $array;
    }
    
    /**
     * Add new cart item and inject price format object if avaliable
     * @param \Plane\Shop\CartItemInterface $item
     */
    protected function addItem(CartItemInterface $item)
    {
        // override item's price format in order to make it consistent with cart's price format
        if (!is_null($this->priceFormat)) {
            $item->setPriceFormat($this->priceFormat);
        }
        
        $this->items[$item->getId()] = $item;
    }
}
