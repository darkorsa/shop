<?php

namespace Plane\Shop\Tests;

use Plane\Shop\Product;
use Plane\Shop\CartItem;
use Plane\Shop\Exception\QuanityException;
use Plane\Shop\Validator\StockQuantityValidator;

class CartItemTest extends \PHPUnit\Framework\TestCase
{
    use MoneyTrait;

    const CURRENCY = 'USD';
    
    protected $product;
    
    protected function setUp(): void
    {
        $this->product = new Product([
            'id'            => 'someID',
            'name'          => 'Test product',
            'price'         => 10.5665,
            'stock'         => 4,
            'taxRate'       => 0.22,
            'weight'        => 5.1,
            'imagePath'     => '/path_to_file/file.jpg',
        ]);
    }

    public function testCartItem()
    {
        $quantity = 3;
        $cartItem = new CartItem($this->product, $quantity, new StockQuantityValidator);

        $this->assertSame($cartItem->getProduct(), $this->product);
        $this->assertSame($cartItem->getId(), $this->product->getId());
        $this->assertSame($cartItem->getName(), $this->product->getName());
        $this->assertSame($cartItem->getImagePath(), $this->product->getImagePath());
        $this->assertSame($cartItem->getQuantity(), $quantity);
        $this->assertSame($cartItem->getWeight(), 5.1);
        $this->assertSame($cartItem->getWeightTotal(), 15.3);

        // money calculations
        $this->assertSame($this->getAmount($cartItem->getTax(self::CURRENCY)), '2.33');
        $this->assertSame($this->getAmount($cartItem->getTaxTotal(self::CURRENCY)), '6.99');
        $this->assertSame($this->getAmount($cartItem->getPrice(self::CURRENCY)), '10.57');
        $this->assertSame($this->getAmount($cartItem->getPriceTotal(self::CURRENCY)), '31.71');
        $this->assertSame($this->getAmount($cartItem->getPriceWithTax(self::CURRENCY)), '12.90');
        $this->assertSame($this->getAmount($cartItem->getPriceTotalWithTax(self::CURRENCY)), '38.70');
    }

    public function testCreateObjectWithStockQuantityValidator()
    {
        $this->expectException(QuanityException::class);

        new CartItem($this->product, 5, new StockQuantityValidator);
    }

    public function testToArray()
    {
        $quantity = 3;
        $cartItem = new CartItem($this->product, $quantity);

        $array = $cartItem->toArray(self::CURRENCY);

        $this->assertSame($array['quantity'], $quantity);
        $this->assertSame($this->getAmount($array['totalTax']), '6.99');
        $this->assertSame($this->getAmount($array['priceTotal']), '31.71');
        $this->assertSame($this->getAmount($array['priceTotalWithTax']), '38.70');
        $this->assertTrue(is_array($array['product']));
    }

    public function testSetQuantity()
    {
        $quantity = 3;
        $cartItem = new CartItem($this->product, $quantity);
        $cartItem->setQuantity(8);

        $this->assertSame($cartItem->getQuantity(), 8);

        // now check with stock validator

        $this->expectException(QuanityException::class);

        $cartItem = new CartItem($this->product, $quantity, new StockQuantityValidator);
        $cartItem->setQuantity(8);
    }

    public function testIncreaseQuantity()
    {
        $quantity = 3;
        $cartItem = new CartItem($this->product, $quantity);
        $cartItem->increaseQuantity(5);

        $this->assertSame($cartItem->getQuantity(), 8);

        // now check with stock validator

        $this->expectException(QuanityException::class);

        $cartItem = new CartItem($this->product, $quantity, new StockQuantityValidator);
        $cartItem->increaseQuantity(3);
    }

    public function testDecreaseQuantity()
    {
        $quantity = 3;
        $cartItem = new CartItem($this->product, $quantity);
        $cartItem->decreaseQuantity(2);

        $this->assertSame($cartItem->getQuantity(), 1);

        $this->expectException(QuanityException::class);

        $cartItem->decreaseQuantity(1);
    }

    public function testDecreaseQuantityWithStockQuantityValidator()
    {
        $this->expectException(QuanityException::class);

        $cartItem = new CartItem($this->product, 3, new StockQuantityValidator);
        $cartItem->decreaseQuantity(3);
    }
}
