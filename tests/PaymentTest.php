<?php

namespace Plane\Shop\Tests;

use Money\Money;
use Plane\Shop\Payment;
use InvalidArgumentException;

/**
 * Payment test suite
 *
 * @author Dariusz Korsak <dkorsak@gmail.com>
 * @package Plane\Shop
 */
class PaymentTest extends \PHPUnit\Framework\TestCase
{
    use MoneyTrait;

    const CURRENCY = 'USD';

    const PAYMENT_INPUT = [
       'id'             => 1,
       'name'           => 'PayPal',
       'description'    => 'Payment with Paypal',
       'fee'            => 4
    ];

    public function testCreateObject()
    {
        $payment = new Payment(self::PAYMENT_INPUT);

        $this->assertSame(self::PAYMENT_INPUT['id'], $payment->getId());
        $this->assertSame(self::PAYMENT_INPUT['name'], $payment->getName());
        $this->assertSame(self::PAYMENT_INPUT['description'], $payment->getDescription());
        $this->assertInstanceOf(Money::class, $payment->getFee($this->getMoney(10), self::CURRENCY));
    }

    public function testCreateIncompleteObject()
    {
        $input = self::PAYMENT_INPUT;
        unset($input['fee']);

        $this->expectException(InvalidArgumentException::class);

        $payment = new Payment($input);
    }

    public function testCreateObjectWithInvalidFeeType()
    {
        $this->expectException(InvalidArgumentException::class);

        $payment = new Payment(self::PAYMENT_INPUT, 'newfeetype');
    }

    public function testFixedFee()
    {
        $payment = Payment::createWithFixedFee(self::PAYMENT_INPUT);
        
        $fee = $payment->getFee($this->getMoney(10), self::CURRENCY);
 
        $this->assertEquals(4.00, $this->getAmount($fee));
    }

    public function testPercentageFee()
    {
        $payment = Payment::createWithPercentageFee(self::PAYMENT_INPUT);

        $fee = $payment->getFee($this->getMoney(10), self::CURRENCY);

        $this->assertEquals(0.40, $this->getAmount($fee));
    }
}
