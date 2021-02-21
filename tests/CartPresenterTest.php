<?php

namespace Plane\Shop\Tests;

use Plane\Shop\CartItem;
use OutOfBoundsException;
use Plane\Shop\CartPresenter;
use Plane\Shop\PaymentInterface;
use Plane\Shop\ShippingInterface;
use Plane\Shop\Discount\TotalPriceThresholdDiscount;

class CartPresenterTest extends \PHPUnit\Framework\TestCase
{
    use MoneyTrait;
    use CartTrait;

    const CURRENCY = 'USD';

    protected $cartPresenter;

    protected function setUp(): void
    {
        $this->createFirstCartItem();
        $this->createSecondCartItem();
        $this->createCart();

        $this->cartPresenter = new CartPresenter($this->cart);
        $this->cartPresenter->setShipping($this->getShippingMock());
        $this->cartPresenter->setPayment($this->getPaymentMock());
    }

    public function testGetCurrency()
    {
        $this->assertSame(self::CURRENCY, $this->cartPresenter->getCurrency());
    }

    public function testGetShipping()
    {
        $this->assertInstanceOf(ShippingInterface::class, $this->cartPresenter->getShipping());
    }

    public function testGetPayment()
    {
        $this->assertInstanceOf(PaymentInterface::class, $this->cartPresenter->getPayment());
    }

    public function testGet()
    {
        $this->assertSame($this->secondCartItem, $this->cartPresenter->get($this->secondCartItem->getId()));
    }

    public function testFailedGet()
    {
        $this->expectException(OutOfBoundsException::class);

        $this->cartPresenter->get('4');
    }

    public function testHas()
    {
        $this->assertTrue($this->cartPresenter->has('1'));
    }

    public function testFailedHas()
    {
        $this->assertFalse($this->cartPresenter->has('4'));
    }

    public function testUpdate()
    {
        $firstAltered  = $this->createMock(CartItem::class);
        $firstAltered->method('getId')->willReturn('1');
        $firstAltered->method('getQuantity')->willReturn(5);

        $this->assertTrue($this->cartPresenter->itemsQuantity() == 3);

        $this->cartPresenter->update($firstAltered);

        $this->assertTrue($this->cartPresenter->itemsQuantity() == 7);
    }

    public function testRemove()
    {
        $this->cartPresenter->remove($this->firstCartItem->getId());

        $this->assertSame([
            2 => $this->secondCartItem
        ], $this->cartPresenter->items());

        $this->assertTrue(count($this->cartPresenter->items()) == 1);
    }

    public function testFailedRemove()
    {
        $this->expectException(OutOfBoundsException::class);

        $this->cartPresenter->remove('3');
    }

    public function testClear()
    {
        $this->cartPresenter->clear();

        $this->assertSame([], $this->cartPresenter->items());
        $this->assertTrue(count($this->cartPresenter->items()) == 0);
    }

    public function testToArray()
    {
        $discount = $this->createMock(TotalPriceThresholdDiscount::class);
        $discount->method('getDescription')->willReturn('Test discount');
        $discount->method('getPriceAfterDiscount')->willReturn($this->getMoney('5'));

        $this->cart->addDiscount($discount);

        $cartPresenter = new CartPresenter($this->cart);

        $array = $cartPresenter->toArray();

        $this->assertTrue(is_array($array));
        $this->assertEmpty(array_diff(['id', 'name', 'desc', 'cost'], array_keys($array['shipping'])));
        $this->assertEmpty(array_diff(['id', 'name', 'desc', 'fee'], array_keys($array['payment'])));
        $this->assertTrue(array_key_exists('itemsQuantity', $array));
        $this->assertTrue(array_key_exists('totalNet', $array));
        $this->assertTrue(array_key_exists('totalGross', $array));
        $this->assertTrue(array_key_exists('tax', $array));
        $this->assertTrue(array_key_exists('totalWeight', $array));
        $this->assertTrue(array_key_exists('shippingCost', $array));
        $this->assertTrue(array_key_exists('paymentFee', $array));
        $this->assertTrue(array_key_exists('totalAfterDiscounts', $array));
    }

    public function testDecoratorMethods()
    {
        $cartPresenter = new CartPresenter($this->cart);

        $this->assertSame($cartPresenter->totalNet(), $this->getAmount($this->cart->totalNet()));
        $this->assertSame($cartPresenter->totalGross(), $this->getAmount($this->cart->totalGross()));
        $this->assertSame($cartPresenter->tax(), $this->getAmount($this->cart->tax()));
        $this->assertSame($cartPresenter->totalAfterDiscounts(), $this->getAmount($this->cart->totalAfterDiscounts()));
        $this->assertSame($cartPresenter->shippingCost(), $this->getAmount($this->cart->shippingCost()));
        $this->assertSame($cartPresenter->paymentFee(), $this->getAmount($this->cart->paymentFee()));
    }
}
