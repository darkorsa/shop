<?php

namespace Plane\Shop\Tests;

use Plane\Shop\Product;
use InvalidArgumentException;

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
    
    const PRODUCT_INPUT = [
        'id'            => 'someID',
        'name'          => 'Test product',
        'price'         => 10.5665,
        'stock'         => 4,
        'taxRate'       => 0.22,
        'weight'        => 5.1,
        'imagePath'     => '/path_to_file/file.jpg',
    ];
    
    const PRODUCT_OUTPUT = [
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
        $product = new Product(self::PRODUCT_INPUT);
        
        $this->assertSame(self::PRODUCT_OUTPUT, [
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

    public function testCreateIncompleteObject()
    {
        $input = self::PRODUCT_INPUT;
        unset($input['price']);

        $this->expectException(InvalidArgumentException::class);

        $payment = new Product($input);
    }
    
    public function testToArray()
    {
        $product = new Product(self::PRODUCT_INPUT);

        $array = $product->toArray(self::CURRENCY);
        
        $this->assertSame(self::PRODUCT_OUTPUT['id'],           $array['id']);
        $this->assertSame(self::PRODUCT_OUTPUT['name'],         $array['name']);
        $this->assertSame(self::PRODUCT_OUTPUT['price'],        $this->getAmount($array['price']));
        $this->assertSame(self::PRODUCT_OUTPUT['stock'],        $array['stock']);
        $this->assertSame(self::PRODUCT_OUTPUT['taxRate'],      $array['taxRate']);
        $this->assertSame(self::PRODUCT_OUTPUT['tax'],          $this->getAmount($array['tax']));
        $this->assertSame(self::PRODUCT_OUTPUT['priceWithTax'], $this->getAmount($array['priceWithTax']));
        $this->assertSame(self::PRODUCT_OUTPUT['weight'],       $array['weight']);
        $this->assertSame(self::PRODUCT_OUTPUT['imagePath'],    $array['imagePath']);
        
    }
}
