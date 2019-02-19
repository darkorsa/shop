<?php

namespace Plane\Shop\Tests;

use Money\Money;
use Money\Currency;
use Plane\Shop\Payment;
use InvalidArgumentException;
use Money\Currencies\ISOCurrencies;
use Money\Parser\DecimalMoneyParser;
use Money\Formatter\DecimalMoneyFormatter;

/**
 * Payment test suite
 *
 * @author Dariusz Korsak <dkorsak@gmail.com>
 * @package Plane\Shop
 */
class PaymentTest extends \PHPUnit\Framework\TestCase
{
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
        $payment = new Payment(self::PAYMENT_INPUT, Payment::FEE_FIXED);
        
        $fee = $payment->getFee($this->getMoney(10), self::CURRENCY);
 
        $this->assertEquals(4.00, $this->getAmount($fee));
    }

    public function testPercentageFee()
    {
        $payment = new Payment(self::PAYMENT_INPUT, Payment::FEE_PERCENTAGE);

        $fee = $payment->getFee($this->getMoney(10), self::CURRENCY);

        $this->assertEquals(0.40, $this->getAmount($fee));
    }

    protected function getMoney($amount)
    {
        $moneyParser = new DecimalMoneyParser(new ISOCurrencies());
        
        return $moneyParser->parse((string) $amount, new Currency(self::CURRENCY));
    }

    protected function getAmount(Money $money)
    {
        $priceFormatter = new DecimalMoneyFormatter(new ISOCurrencies());

        return $priceFormatter->format($money);
    }
}
