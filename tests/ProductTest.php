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
        'imagePath'     => '/path_to_file/file.jpg',
        'taxRate'       => '0.22',
    ];
    
    protected $productOutput = [
        'id'            => '1',
        'name'          => 'Test product',
        'imagePath'     => '/path_to_file/file.jpg',
        'quantity'      => 4,       // converted to int
        'taxRate'       => 0.22,    // converted to double
        'tax'           => 2.2,     // converted to double
        'price'         => 10.0,    // converted to double
        'weight'        => 5.0,     // converted to double
        'priceWithTax'  => 12.2,    // converted to double
    ];
    
    public function testCreateObject()
    {
        $product = new Product($this->productInput);
        
        $this->assertSame($this->productOutput, [
            'id'                => $product->getId(),
            'name'              => $product->getName(),
            'imagePath'         => $product->getImagePath(),
            'quantity'          => $product->getQuantity(),
            'taxRate'           => $product->getTaxRate(),
            'tax'               => $product->getTax(),
            'price'             => $product->getPrice(),
            'weight'            => $product->getWeight(),
            'priceWithTax'      => $product->getPriceWithTax(),
        ]);
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
    
    public function testToArray()
    {
        $product = new Product($this->productInput);
        
        $this->assertSame($product->toArray(), $this->productOutput);
        
    }
    
    
}
