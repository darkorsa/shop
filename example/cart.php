<?php

require_once __DIR__ . '/../vendor/autoload.php'; // Autoload files using Composer autoload

use Plane\Shop\Cart;
use Plane\Shop\Product;
use Plane\Shop\CartItemFactory;

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

$cartItem1 = CartItemFactory::create($product1, 4, 'english');
$cartItem2 = CartItemFactory::create($product2, 'english');

$cart = new Cart();
$cart->add($cartItem1);
$cart->add($cartItem2);

echo 'Total items: ' . $cart->totalItems() . "\n\n";
echo 'Total: ' . $cart->total() . "\n\n";
echo 'Total with tax: ' . $cart->totalWithTax() . "\n\n";
echo 'Total tax: ' . $cart->totalTax() . "\n\n";
