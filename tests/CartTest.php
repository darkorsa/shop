<?php

namespace Plane\Shop\Tests;

use Plane\Shop\Cart;
use Plane\Shop\Payment;
use Plane\Shop\CartItem;
use Plane\Shop\Shipping;
use OutOfBoundsException;
use Plane\Shop\CartItemCollection;

class CartTest extends \PHPUnit\Framework\TestCase
{
    const CURRENCY = 'USD';

    protected $firstCartItem;

    protected $secondCartItem;

    protected function setUp(): void
    {
        $this->firstCartItem  = $this->createMock(CartItem::class);
        $this->firstCartItem->method('getId')->willReturn(1);
        $this->firstCartItem->method('getQuantity')->willReturn(1);

        $this->secondCartItem = $this->createMock(CartItem::class);
        $this->secondCartItem->method('getId')->willReturn(2);
        $this->secondCartItem->method('getQuantity')->willReturn(2);
    }
    
    public function testGetCurrency()
    {
        $cart = new Cart(self::CURRENCY);

        $this->assertSame(self::CURRENCY, $cart->getCurrency());
    }

    public function testSetShipping()
    {
        $shipping = $this->createMock(Shipping::class);
        
        $cart = new Cart(self::CURRENCY);
        $cart->setShipping($shipping);

        $this->assertSame($shipping, $cart->getShipping());
    }

    public function testSetPayment()
    {
        $payment = $this->createMock(Payment::class);
        
        $cart = new Cart(self::CURRENCY);
        $cart->setPayment($payment);

        $this->assertSame($payment, $cart->getPayment());
    }

    public function testFill()
    {
        $cartItemCollection = new CartItemCollection;
        $cartItemCollection->addItem($this->firstCartItem);
        $cartItemCollection->addItem($this->secondCartItem);
        
        $cart = new Cart(self::CURRENCY);
        $cart->fill($cartItemCollection);

        $this->assertSame([
            1 => $this->firstCartItem,
            2 => $this->secondCartItem
        ], $cart->items());
        
        $this->assertTrue(count($cart->items()) == 2);
    }

    public function testAdd()
    {
        $cart = new Cart(self::CURRENCY);
        $cart->add($this->firstCartItem);
        $cart->add($this->secondCartItem);
        $cart->add($this->secondCartItem); // increase quantity

        $this->assertSame([
            1 => $this->firstCartItem,
            2 => $this->secondCartItem
        ], $cart->items());
        
        $this->assertTrue(count($cart->items()) == 2);
    }

    public function testGet()
    {
        $cart = new Cart(self::CURRENCY);
        $cart->add($this->firstCartItem);
        $cart->add($this->secondCartItem);

        $this->assertSame($this->secondCartItem, $cart->get($this->secondCartItem->getId()));
    }

    public function testFailedGet()
    {
        $cart = new Cart(self::CURRENCY);
        $cart->add($this->firstCartItem);

        $this->expectException(OutOfBoundsException::class);

        $cart->get('4');
    }

    public function testUpdate()
    {
        $firstAltered  = $this->createMock(CartItem::class);
        $firstAltered->method('getId')->willReturn(1);
        $firstAltered->method('getQuantity')->willReturn(5);
        
        $cart = new Cart(self::CURRENCY);
        $cart->add($this->firstCartItem);

        $this->assertTrue($cart->itemsQuantity() == 1);
        
        $cart->update($firstAltered);

        $this->assertTrue($cart->itemsQuantity() == 5);
    }

    public function testRemove()
    {
        $cart = new Cart(self::CURRENCY);
        $cart->add($this->firstCartItem);
        $cart->add($this->secondCartItem);

        $cart->remove($this->firstCartItem->getId());

        $this->assertSame([
            2 => $this->secondCartItem
        ], $cart->items());

        $this->assertTrue(count($cart->items()) == 1);
    }

    public function testFailedRemove()
    {
        $cart = new Cart(self::CURRENCY);
        $cart->add($this->firstCartItem);
        $cart->add($this->secondCartItem);

        $this->expectException(OutOfBoundsException::class);

        $cart->remove('3');
    }

    public function testClear()
    {
        $cart = new Cart(self::CURRENCY);
        $cart->add($this->firstCartItem);
        $cart->add($this->secondCartItem);

        $cart->clear();

        $this->assertSame([], $cart->items());
        $this->assertTrue(count($cart->items()) == 0);
    }

    public function testItemsQuantity()
    {
        $cart = new Cart(self::CURRENCY);
        $cart->add($this->firstCartItem);
        $cart->add($this->secondCartItem);

        $this->assertTrue(($cart->itemsQuantity()) == 3);
    }
}