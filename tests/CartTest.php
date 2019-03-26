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
    use MoneyTrait;
    
    const CURRENCY = 'USD';

    protected $firstCartItem;

    protected $secondCartItem;

    protected function setUp(): void
    {
        $this->firstCartItem  = $this->createMock(CartItem::class);
        $this->firstCartItem->method('getId')->willReturn(1);
        $this->firstCartItem->method('getQuantity')->willReturn(1);
        $this->firstCartItem->method('getWeightTotal')->willReturn(5.33);
        $this->firstCartItem->method('getPriceTotal')->willReturn($this->getMoney('3.5'));
        $this->firstCartItem->method('getPriceTotalWithTax')->willReturn($this->getMoney('4.27'));
        $this->firstCartItem->method('getTaxTotal')->willReturn($this->getMoney('0.77'));

        $this->secondCartItem = $this->createMock(CartItem::class);
        $this->secondCartItem->method('getId')->willReturn(2);
        $this->secondCartItem->method('getQuantity')->willReturn(2);
        $this->secondCartItem->method('getWeightTotal')->willReturn(4.67);
        $this->secondCartItem->method('getPriceTotal')->willReturn($this->getMoney('8'));
        $this->secondCartItem->method('getPriceTotalWithTax')->willReturn($this->getMoney('9.76'));
        $this->secondCartItem->method('getTaxTotal')->willReturn($this->getMoney('1.76'));
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

        $this->assertTrue($cart->itemsQuantity() == 3);
    }

    public function testWeight()
    {
        $cart = new Cart(self::CURRENCY);
        $cart->add($this->firstCartItem);
        $cart->add($this->secondCartItem);

        $this->assertTrue($cart->weight() == 10.00);
    }

    public function testTotalNet()
    {
        $cart = new Cart(self::CURRENCY);
        $cart->add($this->firstCartItem);
        $cart->add($this->secondCartItem);

        $this->assertTrue($this->getAmount($cart->totalNet()) == 11.50);
    }

    public function testTotalGross()
    {
        $cart = new Cart(self::CURRENCY);
        $cart->add($this->firstCartItem);
        $cart->add($this->secondCartItem);

        $this->assertTrue($this->getAmount($cart->totalGross()) == 14.03);
    }

    public function testTax()
    {
        $cart = new Cart(self::CURRENCY);
        $cart->add($this->firstCartItem);
        $cart->add($this->secondCartItem);

        $this->assertTrue($this->getAmount($cart->tax()) == 2.53);
    }

    public function testShippingCost()
    {
        $shipping  = $this->createMock(Shipping::class);
        $shipping->method('getCost')->willReturn($this->getMoney('4.00'));
        
        $cart = new Cart(self::CURRENCY);
        $cart->setShipping($shipping);

        $this->assertTrue($this->getAmount($cart->shippingCost()) == 4.00);
    }

    public function testShippingCostWhenNoShippingSet()
    {
        $cart = new Cart(self::CURRENCY);

        $this->assertTrue($this->getAmount($cart->shippingCost()) == 0.00);
    }
}