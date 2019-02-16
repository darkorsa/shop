<?php

namespace Plane\Shop\Tests;

use Money\Money;
use Plane\Shop\Shipping;

/**
 * Shipping test suite
 *
 * @author Dariusz Korsak <dkorsak@gmail.com>
 * @package Plane\Shop
 */
class ShippingTest extends \PHPUnit\Framework\TestCase
{
    protected $shippingInput = [
       'id'             => 1,
       'name'           => 'National postal services',
       'description'    => '',
       'cost'           => 3.4
    ];

    public function testCreateObject()
    {
        $shipping = new Shipping($this->shippingInput);

        $this->assertSame($this->shippingInput['id'], $shipping->getId());
        $this->assertSame($this->shippingInput['name'], $shipping->getName());
        $this->assertSame($this->shippingInput['description'], $shipping->getDescription());

        //$this->assertInstanceOf(Money::class, $shipping->getCost());
    }
}
