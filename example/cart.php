<?php

require_once __DIR__ . '/../vendor/autoload.php'; // Autoload files using Composer autoload

use Plane\Shop\Cart;
use Plane\Shop\CartItem;
use Plane\Shop\Product;
use Plane\Shop\CartItemCollection;
use Plane\Shop\CartItemsDecorator;

$product1 = new Product([
    'id'        => 1,
    'name'      => 'Commander Graven Il-vec',
    'price'     => 19.43,
    'imagePath' => '/resources/singles/commander.jpg',
    'taxRate'   => 0.23
]);

$product2 = new Product([
    'id'        => 2,
    'name'      => 'Wall of Blossoms',
    'price'     => 4.00,
    'imagePath' => '/resources/singles/wall.jpg',
    'taxRate'   => 0.23
]);

$cartItemCollection = new CartItemCollection;
$cartItemCollection->addItem(new CartItem($product1, 4));
$cartItemCollection->addItem(new CartItem($product2, 1));

$cartItemsDecorator = new CartItemsDecorator($cartItemCollection, 'Plane\\Shop\\PriceFormat\\EnglishFormat');
$cartItemsDecorator->decorate();

$cart = new Cart($cartItemCollection);

echo 'Total items: ' . $cart->totalItems() . "\n\n";
echo 'Total: ' . $cart->total() . "\n\n";
echo 'Total with tax: ' . $cart->totalWithTax() . "\n\n";
echo 'Total tax: ' . $cart->totalTax() . "\n\n";

//var_dump($cart->toArray());
