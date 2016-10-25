<?php

namespace Plane\Shop;

use Plane\Shop\CartItemInterface;

/**
 * Trait for common methods in cart decorators
 *
 * @author Dariusz Korsak <dkorsak@gmail.com>
 * @packate Plane\Shop
 */
trait CartDecoratorTrait
{
    protected $cart;
    
    /**
     * Set shipping object
     * @param \Plane\Shop\ShippingInterface $shipping
     */
    public function setShipping(ShippingInterface $shipping)
    {
        $this->cart->setShipping($shipping);
    }
    
    /**
     * Return shipping object
     * @return \Plane\Shop\ShippingInterface
     */
    public function getShipping()
    {
        return $this->cart->getShipping();
    }
    
    /**
     * Set payment object
     * @param \Plane\Shop\PaymentInterface $payment
     */
    public function setPayment(PaymentInterface $payment)
    {
        $this->cart->setPayment($payment);
    }
    
    /**
     * Return payment object
     * @return \Plane\Shop\PaymentInterface
     */
    public function getPayment()
    {
        return $this->cart->getPayment();
    }
    
    /**
     * Add discount
     * @param \Plane\Shop\CartDiscount $discount
     */
    public function addDiscount(CartDiscount $discount)
    {
        $this->cart->addDiscount($discount);
    }
    
    /**
     * Fill cart with items
     * @param \Plane\Shop\CartItemCollection $collection
     */
    public function fill(CartItemCollection $collection)
    {
        $this->cart->fill($collection);
    }
    
    /**
     * Add cart item
     * @param \Plane\Shop\CartItemInterface $item
     */
    public function add(CartItemInterface $item)
    {
        $this->cart->add($item);
    }
    
    /**
     * Remove cart item
     * @param int $itemId
     * @throws \DomainException
     */
    public function remove($itemId)
    {
        $this->cart->remove($itemId);
    }
    
    /**
     * Replace cart item
     * @param \Plane\Shop\CartItemInterface $item
     */
    public function update(CartItemInterface $item)
    {
        $this->cart->update($item);
    }
    
    /**
     * Check if cart item with given id exists
     * @param int $itemId
     * @return boolean
     */
    public function has($itemId)
    {
        return $this->cart->has($itemId);
    }
    
    /**
     * Return cart item object
     * @param int $itemId
     * @return \Plane\Shop\CartItemInterface
     * @throws \DomainException
     */
    public function get($itemId)
    {
        return $this->cart->get($itemId);
    }
    
    /**
     * Return array of cart items
     * @return array
     */
    public function all()
    {
        return $this->cart->all();
    }
    
    /**
     * Remove all cart items
     */
    public function clear()
    {
        $this->cart->clear();
    }
    
    /**
     * Return sum of cart items prices with tax
     * @return float
     */
    public function total()
    {
        return $this->cart->total();
    }
    
    /**
     * Return number of cart items
     * @return int
     */
    public function totalItems()
    {
        return $this->cart->totalItems();
    }

    /**
     * Return sum of cart items tax
     * @return float
     */
    public function totalTax()
    {
        return $this->cart->totalTax();
    }
    
    /**
     * Return total weight of all items
     * return float
     */
    public function totalWeight()
    {
        return $this->cart->totalWeight();
    }
    
    /**
     * Return price after discounts
     * @return float
     */
    public function totalAfterDisconuts()
    {
        return $this->cart->totalAfterDisconuts();
    }
    
    /**
     * Return shipping cost
     * @return float
     */
    public function shippingCost()
    {
        return $this->cart->shippingCost();
    }
    
    /**
     * Return payment fee
     * @return float
     */
    public function paymentFee()
    {
        return $this->cart->paymentFee();
    }
    
    /**
     * Cast object to array
     * @return array
     */
    public function toArray()
    {
        return $this->cart->toArray();
    }
}
