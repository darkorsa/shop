<?php

namespace Plane\Shop;

use Plane\Shop\CartItemInterface;

/**
 * Description of CartDecoratorTrait
 *
 * @author Dariusz Korsak <dkorsak@gmail.com>
 * @packate Plane\Shop
 */
trait CartDecoratorTrait
{
    protected $cart;
    
    public function setShipping(ShippingInterface $shipping)
    {
        $this->cart->setShipping($shipping);
    }
    
    public function setPayment(PaymentInterface $payment)
    {
        $this->cart->setPayment($payment);
    }
    
    public function fill(CartItemCollection $collection)
    {
        $this->cart->fill($collection);
    }
    
    public function add(CartItemInterface $item)
    {
        $this->cart->add($item);
    }
    
    public function remove($itemId)
    {
        $this->cart->remove($itemId);
    }
    
    public function update(Product $item)
    {
        $this->cart->update($item);
    }
    
    public function has($itemId)
    {
        return $this->cart->has($itemId);
    }
    
    public function get($itemId)
    {
        return $this->cart->get($itemId);
    }
    
    public function all()
    {
        return $this->cart->all();
    }
    
    public function clear()
    {
        $this->cart->clear();
    }
    
    public function totalItems()
    {
        return $this->cart->totalItems();
    }
    
    public function total()
    {
        return $this->cart->total();
    }

    public function totalTax()
    {
        return $this->cart->totalTax();
    }
    
    public function shippingCost()
    {
        return $this->cart->shippingCost();
    }
    
    public function paymentFee()
    {
        return $this->cart->paymentFee();
    }
    
    public function toArray()
    {
        return $this->toArray();
    }
}
