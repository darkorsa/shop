<?php

namespace Plane\Shop\Tests;

use Plane\Shop\CartItem;
use Plane\Shop\CartItemCollection;

class CartItemCollectionTest extends \PHPUnit\Framework\TestCase
{
    public function testCollection()
    {
        $firstCartItem  = $this->createMock(CartItem::class);
        $secondCartItem = $this->createMock(CartItem::class);

        $cartItemCollection = new CartItemCollection;
        $cartItemCollection->addItem($firstCartItem);
        $cartItemCollection->addItem($secondCartItem);

        $this->assertTrue($cartItemCollection->length() == 2);
        $this->assertSame([
            0 => $firstCartItem,
            1 => $secondCartItem
        ], $cartItemCollection->getItems());
    }
}
