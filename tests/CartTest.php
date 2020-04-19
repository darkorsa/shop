<?php

namespace Plane\Shop\Tests;

use Plane\Shop\Cart;
use Plane\Shop\CartItem;
use OutOfBoundsException;
use Plane\Shop\PaymentInterface;
use Plane\Shop\ShippingInterface;
use Plane\Shop\CartItemCollection;
use Plane\Shop\Discount\EverySecondItemFreeDiscount;
use Plane\Shop\Discount\TotalPriceThresholdDiscount;

class CartTest extends \PHPUnit\Framework\TestCase
{
    use MoneyTrait;
    use CartTrait;

    const CURRENCY = 'USD';

    protected function setUp(): void
    {
        $this->createFirstCartItem();
        $this->createSecondCartItem();
        $this->createCart();
    }

    public function testGetCurrency()
    {
        $this->assertSame(self::CURRENCY, $this->cart->getCurrency());
    }

    public function testGetShipping()
    {
        $this->assertInstanceOf(ShippingInterface::class, $this->cart->getShipping());
    }

    public function testGetPayment()
    {
        $this->assertInstanceOf(PaymentInterface::class, $this->cart->getPayment());
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
        $this->cart->add($this->secondCartItem);

        $this->assertSame([
            1 => $this->firstCartItem,
            2 => $this->secondCartItem
        ], $this->cart->items());

        $this->assertTrue(count($this->cart->items()) == 2);
    }

    public function testGet()
    {
        $this->assertSame($this->secondCartItem, $this->cart->get($this->secondCartItem->getId()));
    }

    public function testFailedGet()
    {
        $this->expectException(OutOfBoundsException::class);

        $this->cart->get('4');
    }

    public function testUpdate()
    {
        $firstAltered  = $this->createMock(CartItem::class);
        $firstAltered->method('getId')->willReturn('1');
        $firstAltered->method('getQuantity')->willReturn(5);

        $cart = new Cart(self::CURRENCY);
        $cart->add($this->firstCartItem);

        $this->assertTrue($cart->itemsQuantity() == 1);

        $cart->update($firstAltered);

        $this->assertTrue($cart->itemsQuantity() == 5);
    }

    public function testRemove()
    {
        $this->cart->remove($this->firstCartItem->getId());

        $this->assertSame([
            2 => $this->secondCartItem
        ], $this->cart->items());

        $this->assertTrue(count($this->cart->items()) == 1);
    }

    public function testFailedRemove()
    {
        $this->expectException(OutOfBoundsException::class);

        $this->cart->remove('3');
    }

    public function testClear()
    {
        $this->cart->clear();

        $this->assertSame([], $this->cart->items());
        $this->assertTrue(count($this->cart->items()) == 0);
    }

    public function testItemsQuantity()
    {
        $this->assertTrue($this->cart->itemsQuantity() == 3);
    }

    public function testWeight()
    {
        $this->assertTrue($this->cart->weight() == 9.99);
    }

    public function testTotalNet()
    {
        $this->assertTrue($this->getAmount($this->cart->totalNet()) == 11.50);
    }

    public function testTotalGross()
    {
        $this->assertTrue($this->getAmount($this->cart->totalGross()) == 14.03);
    }

    public function testTax()
    {
        $this->assertTrue($this->getAmount($this->cart->tax()) == 2.53);
    }

    public function testShippingCost()
    {
        $this->assertTrue($this->getAmount($this->cart->shippingCost()) == 4.00);
    }

    public function testShippingCostWhenNoShippingSet()
    {
        $cart = new Cart(self::CURRENCY);

        $this->assertTrue($this->getAmount($cart->shippingCost()) == 0.00);
    }

    public function testPaymentFee()
    {
        $this->assertTrue($this->getAmount($this->cart->paymentFee()) == 5.50);
    }

    public function testPaymentFeeWhenNoPaymentSet()
    {
        $cart = new Cart(self::CURRENCY);

        $this->assertTrue($this->getAmount($cart->paymentFee()) == 0.00);
    }

    public function testDiscounts()
    {
        $cartDiscount = new TotalPriceThresholdDiscount('Discount description', $this->cart, [
            'treshold' => 14,
            'discount' => 0.1
        ]);
        $this->cart->addDiscount($cartDiscount);

        $this->assertTrue($this->cart->getDiscounts() == [0 => $cartDiscount]);
    }

    public function testTotalAfterDiscounts()
    {
        $secondFreeDisount = new EverySecondItemFreeDiscount('Every second product is free', $this->cart, [
            'items' => $this->cart->items()
        ]);
        $this->cart->addDiscount($secondFreeDisount);

        $priceTresholdDiscount = new TotalPriceThresholdDiscount('Discount description', $this->cart, [
            'treshold' => 4,
            'discount' => 0.5
        ]);
        $this->cart->addDiscount($priceTresholdDiscount);

        $this->assertTrue($this->getAmount($this->cart->totalAfterDiscounts()) == 2.13);
    }
}
