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
    use MoneyTrait;
    
    const CURRENCY = 'USD';
    
    protected $productInput = [
        'id'            => 'someID',
        'name'          => 'Test product',
        'price'         => 10.5665,
        'stock'         => 4,
        'taxRate'       => 0.22,
        'weight'        => 5.1,
        'imagePath'     => '/path_to_file/file.jpg',
    ];
    
    protected $productOutput = [
        'id'            => 'someID',
        'name'          => 'Test product',
        'price'         => '10.57',
        'stock'         => 4,
        'taxRate'       => 0.22,
        'tax'           => '2.33',
        'priceWithTax'  => '12.90',
        'weight'        => 5.1,
        'imagePath'     => '/path_to_file/file.jpg',
    ];
    
    public function testCreateObject()
    {
        $product = new Product($this->productInput);
        
        $this->assertSame($this->productOutput, [
            'id'                => $product->getId(),
            'name'              => $product->getName(),
            'price'             => $this->getAmount($product->getPrice(self::CURRENCY)),
            'stock'             => $product->getStock(),
            'taxRate'           => $product->getTaxRate(),
            'tax'               => $this->getAmount($product->getTax(self::CURRENCY)),
            'priceWithTax'      => $this->getAmount($product->getPriceWithTax(self::CURRENCY)),
            'weight'            => $product->getWeight(),
            'imagePath'         => $product->getImagePath(),
        ]);
    }
    
    public function _testToArray()
    {
        $product = new Product($this->productInput);
        
        $this->assertSame($product->toArray(), $this->productOutput);
    }
}
