<?php

namespace Plane\Shop;

/**
 * Interface for Cart classes
 *
 * @author Dariusz Korsak <dkorsak@gmail.com>
 * @package Plane\Shop;
 */
interface CartInterface
{
    /**
     * Set shipping object
     * @param \Plane\Shop\ShippingInterface $shipping
     */
    public function setShipping(ShippingInterface $shipping);
    
    /**
     * Set payment object
     * @param \Plane\Shop\PaymentInterface $payment
     */
    public function setPayment(PaymentInterface $payment);
    
    /**
     * Add discount
     * @param \Plane\Shop\CartDiscount $discount
     */
    public function addDiscount(CartDiscount $discount);
    
    /**
     * Fill cart with items
     * @param \Plane\Shop\CartItemCollection $collection
     */
    public function fill(CartItemCollection $collection);
    
    /**
     * Add cart item
     * @param \Plane\Shop\CartItemInterface $item
     */
    public function add(CartItemInterface $item);
    
    /**
     * Remove cart item
     * @param int $itemId
     * @throws \DomainException
     */
    public function remove($itemId);
    
    /**
     * Replace cart item
     * @param \Plane\Shop\Product $item
     */
    public function update(Product $item);
    
    /**
     * Check if cart item with given id exists
     * @param int $itemId
     * @return boolean
     */
    public function has($itemId);
    
    /**
     * Return cart item object
     * @param int $itemId
     * @return \Plane\Shop\CartItemInterface
     * @throws \DomainException
     */
    public function get($itemId);
    
    /**
     * Return array of cart items
     * @return array
     */
    public function all();
    
    /**
     * Remove all cart items
     */
    public function clear();
    
    /**
     * Return sum of cart items prices with tax
     * @return float
     */
    public function total();
    
    /**
     * Return number of cart items
     * @return int
     */
    public function totalItems();
    
    /**
     * Return sum of cart items tax
     * @return float
     */
    public function totalTax();
    
    /**
     * Return price after discounts
     * @return float
     */
    public function totalAfterDisconuts();
    
    /**
     * Return shipping cost
     * @return float
     */
    public function shippingCost();
    
    /**
     * Return payment fee
     * @return float
     */
    public function paymentFee();
    
    /**
     * Cast object to array
     * @return array
     */
    public function toArray();
}
