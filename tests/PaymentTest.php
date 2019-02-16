<?php

namespace Plane\Shop\Tests;

use Money\Money;
use Plane\Shop\Payment;

/**
 * Payment test suite
 *
 * @author Dariusz Korsak <dkorsak@gmail.com>
 * @package Plane\Shop
 */
class PaymentTest extends \PHPUnit\Framework\TestCase
{
    protected $paymentInput = [
       'id'             => 1,
       'name'           => 'PayPal',
       'description'    => 'Payment with Paypal',
       'fee'            => 0.2
    ];

    public function testCreateObject()
    {
        $payment = new Payment($this->paymentInput, Payment::FEE_FIXED);

        $this->assertSame($this->paymentInput['id'], $payment->getId());
        $this->assertSame($this->paymentInput['name'], $payment->getName());
        $this->assertSame($this->paymentInput['description'], $payment->getDescription());

        //$this->assertInstanceOf(Money::class, $payment->getFee(10));

    }

    public function testPercentageFee()
    {
        $payment = new Payment($this->paymentInput, Payment::FEE_PERCENTAGE);

        //$this->assertInstanceOf(Money::class, $payment->getFee(10));

        //$this->assertSame(2.0, $payment->getFee(10));
    }
}
