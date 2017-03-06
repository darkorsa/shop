<?php

namespace Plane\Shop\Tests;

use Plane\Shop\Product;
use Plane\Shop\PriceFormat\EnglishFormat as PriceFormat;

/**
 * Product test suite
 *
 * @author Dariusz Korsak <dkorsak@gmail.com>
 * @package Plane\Shop
 */
class ProductTest extends \PHPUnit\Framework\TestCase
{
    protected $productInput = [
        'id'            => '1',
        'name'          => 'Test product',
        'price'         => '10',
        'weight'        => '5',
        'quantity'      => '4',
        'imagePath'    => '/path_to_file/file.jpg',
        'taxRate'       => '0.22',
    ];
    
    public function testCreateObject()
    {
        $product = new Product($this->productInput);
        
        $this->assertSame('1', $product->getId());
        $this->assertSame('Test product', $product->getName());
        $this->assertSame(10.0, $product->getPrice());
        $this->assertSame(5.0, $product->getWeight());
        $this->assertSame(4, $product->getQuantity());
        $this->assertSame('/path_to_file/file.jpg', $product->getImagePath());
        $this->assertSame(0.22, $product->getTaxRate());
        $this->assertSame(2.2, $product->getTax());
        
        // due to imprecision of php floats
        $this->assertEquals(12.2, $product->getPriceWithTax());
    }
    
    public function testSetPrice()
    {
        $product = new Product($this->productInput);
        $product->setPrice(123);
        
        $this->assertSame(123.0, $product->getPrice());
    }
    
    public function testSetPriceFormat()
    {
        $priceFormat = $this->getMockBuilder(PriceFormat::class)
            ->getMock();
        
        $priceFormat->expects($this->any())
            ->method('formatPrice')
            ->willReturn(12.20);
        
        $product = new Product($this->productInput);
        $product->setPriceFormat($priceFormat);
        
        $this->assertSame(12.20, $product->getPriceWithTax());
    }
    
    
}
