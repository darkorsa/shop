<?php

namespace Plane\Shop\Tests;

use Plane\Shop\Shipping;
use Plane\Shop\PriceFormat\EnglishFormat as PriceFormat;

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

        $this->assertSame($this->shippingInput, [
            'id'                => $shipping->getId(),
            'name'              => $shipping->getName(),
            'description'       => $shipping->getDescription(),
            'cost'              => $shipping->getCost(),
        ]);
    }
    
    public function testSetCost()
    {
        $shipping = new Shipping($this->shippingInput);
        $shipping->setCost(2);
        
        $this->assertSame(2.00, $shipping->getCost());
    }

    public function testSetPriceFormat()
    {
        $priceFormat = $this->getMockBuilder(PriceFormat::class)->getMock();
        
        $priceFormat->expects($this->any())
            ->method('formatPrice')
            ->willReturn(3.40);
        
        $shipping = new Shipping($this->shippingInput);
        $shipping->setPriceFormat($priceFormat);
        
        $this->assertSame(3.40, $shipping->getCost());
    }
}
