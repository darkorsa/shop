<?php

namespace Plane\Shop\Tests;

use Money\Money;
use Plane\Shop\Shipping;
use InvalidArgumentException;

/**
 * Shipping test suite
 *
 * @author Dariusz Korsak <dkorsak@gmail.com>
 * @package Plane\Shop
 */
class ShippingTest extends \PHPUnit\Framework\TestCase
{
    use MoneyTrait;
    
    const CURRENCY = 'USD';
    
    const SHIPPING_INPUT = [
       'id'             => 1,
       'name'           => 'National postal services',
       'description'    => '',
       'cost'           => 3.4
    ];

    public function testCreateObject()
    {
        $shipping = new Shipping(self::SHIPPING_INPUT);

        $this->assertSame(self::SHIPPING_INPUT['id'], $shipping->getId());
        $this->assertSame(self::SHIPPING_INPUT['name'], $shipping->getName());
        $this->assertSame(self::SHIPPING_INPUT['description'], $shipping->getDescription());

        $this->assertInstanceOf(Money::class, $shipping->getCost(self::CURRENCY));
        $this->assertEquals(3.40, $this->getAmount($shipping->getCost(self::CURRENCY)));
    }

    public function testCreateIncompleteObject()
    {
        $input =self::SHIPPING_INPUT;
        unset($input['cost']);

        $this->expectException(InvalidArgumentException::class);

        $shipping = new Shipping($input);
    }

    public function testAmount()
    {
        $input = self::SHIPPING_INPUT;

        $sample = [
            '1.11'      => 1.11411,
            '5.58'      => 5.5811,
            '2.51'      => 2.509,
        ];

        foreach ($sample as $expected => $cost) {
            $input['cost'] = $cost;

            $shipping = new Shipping($input);

            $this->assertSame($expected, $this->getAmount($shipping->getCost(self::CURRENCY)));
        }
    }
}
