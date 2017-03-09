<?php

namespace Plane\Shop\Tests;

use Plane\Shop\Payment;
use Plane\Shop\PriceFormat\EnglishFormat as PriceFormat;

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
        $payment = new Payment($this->paymentInput);
        $payment->setFixed();

        $this->assertSame($this->paymentInput, [
            'id'                => $payment->getId(),
            'name'              => $payment->getName(),
            'description'       => $payment->getDescription(),
            'fee'               => $payment->getFee(10),
        ]);
    }

    public function testPercentageFee()
    {
        $payment = new Payment($this->paymentInput);
        $payment->setPercentage();

        $this->assertSame(2.0, $payment->getFee(10));
    }

    public function testSetPriceFormat()
    {
        $priceFormat = $this->getMockBuilder(PriceFormat::class)
            ->getMock();
        
        $priceFormat->expects($this->any())
            ->method('formatPrice')
            ->willReturn(2.00);
        
        $payment = new Payment($this->paymentInput);
        $payment->setPriceFormat($priceFormat);
        
        $this->assertSame(2.00, $payment->getFee(10));
    }
}
