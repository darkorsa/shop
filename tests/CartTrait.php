<?php

namespace Plane\Shop\Tests;

use Plane\Shop\Cart;
use Plane\Shop\Payment;
use Plane\Shop\Product;
use Plane\Shop\CartItem;
use Plane\Shop\Shipping;

trait CartTrait
{
    protected $cart;

    protected $firstCartItem;

    protected $secondCartItem;

    protected function createFirstCartItem()
    {
        $product = new Product([
            'id'            => '1',
            'name'          => 'Test product',
            'price'         => 3.5,
            'stock'         => 5,
            'taxRate'       => 0.22,
            'weight'        => 5.33,
        ]);
        
        $this->firstCartItem = new CartItem($product);
    }

    protected function createSecondCartItem()
    {
        $product = new Product([
            'id'            => '2',
            'name'          => 'Second test product',
            'price'         => 4,
            'stock'         => 5,
            'taxRate'       => 0.22,
            'weight'        => 2.33,
        ]);

       $this->secondCartItem = new CartItem($product, 2);
    }

    protected function getPaymentMock()
    {
        $payment = $this->createMock(Payment::class);
        $payment->method('getId')->willReturn(1);
        $payment->method('getName')->willReturn('Test payment');
        $payment->method('getDescription')->willReturn('Payment description');
        $payment->method('getFee')->willReturn($this->getMoney('5.50'));

        return $payment;
    }

    protected function getShippingMock()
    {
        $shipping  = $this->createMock(Shipping::class);
        $shipping->method('getId')->willReturn(1);
        $shipping->method('getName')->willReturn('Test shipping');
        $shipping->method('getDescription')->willReturn('Shipping description');
        $shipping->method('getCost')->willReturn($this->getMoney('4.00'));

        return $shipping;
    }

    protected function createCart()
    {
        $cart = new Cart(self::CURRENCY);
        $cart->add($this->firstCartItem);
        $cart->add($this->secondCartItem);
        $cart->setShipping($this->getShippingMock());
        $cart->setPayment($this->getPaymentMock());

        $this->cart = $cart;
    }
}