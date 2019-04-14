<?php

namespace Plane\Shop\Tests;

use Plane\Shop\Cart;
use Plane\Shop\Discount\TotalPriceThresholdDiscount;

class CartDiscountTest extends \PHPUnit\Framework\TestCase
{
    public function testCartDiscount()
    {
        $cart = new Cart('USD');
       
        $cartDiscount = new TotalPriceThresholdDiscount('Discount description', $cart, [
            'treshold' => 14,
            'discount' => 0.1
        ]);

        $this->assertSame($cartDiscount->getDescription(), 'Discount description');
    }
}