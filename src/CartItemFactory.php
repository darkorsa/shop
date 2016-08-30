<?php

namespace Plane\Shop;

use Plane\Shop\PriceFormat\EnglishFormat;

class CartItemFactory
{
    public static function create(ProductInterface $product, $quantity = 1, $priceFormat = null)
    {
        switch ($priceFormat) {
            case 'english':
                return new EnglishFormat(new CartItem($product, $quantity));
            default:
                return new CartItem($product, $quantity);
        }
    }
}
