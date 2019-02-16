<?php

namespace Plane\Shop\Tests;

use Plane\Shop\Product;

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
        'price'         => 10,
        'weight'        => 5,
        'stock'         => 4,
        'taxRate'       => 0.22,
        'imagePath'     => '/path_to_file/file.jpg',
    ];
    
    protected $productOutput = [
        'id'            => '1',
        'name'          => 'Test product',
        'imagePath'     => '/path_to_file/file.jpg',
        'stock'         => 4,       
        'taxRate'       => 0.22,    
        'tax'           => 2.2,     
        'price'         => 10.0,    
        'weight'        => 5.0,     
        'priceWithTax'  => 12.2,  
    ];
    
    public function _testCreateObject()
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
    
    public function _testSetPrice()
    {
        $product = new Product($this->productInput);
        $product->setPrice(123);
        
        $this->assertSame(123.0, $product->getPrice());
    }
    
    public function _testToArray()
    {
        $product = new Product($this->productInput);
        
        $this->assertSame($product->toArray(), $this->productOutput);
    }
}
