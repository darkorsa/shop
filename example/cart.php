<?php

require_once __DIR__ . '/../vendor/autoload.php'; // Autoload files using Composer autoload

use Plane\Shop\Cart;
use Plane\Shop\CartItem;
use Plane\Shop\Product;
use Plane\Shop\Payment;
use Plane\Shop\Shipping;
use Plane\Shop\CartDiscount;
use Plane\Shop\CartItemCollection;

use Plane\Shop\PriceFormat\EnglishFormat;

use Plane\Shop\Discount\SecondItemFreeDiscount;
use Plane\Shop\Discount\TotalPriceThresholdDiscount;

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

$priceFormat = new EnglishFormat();

$shipping = new Shipping([
   'id'             => 9,
   'name'           => 'Poczta polska',
   'description'    => 'Wysylka poczta polska costam costam',
   'cost'           => 15
]);

$payment = new Payment([
   'id'             => 1,
   'name'           => 'PayPal',
   'description'    => 'Platnosc paypal + 4zl do kosztu zamowienia',
   'fee'           => 4
]);

$cart = new Cart($priceFormat);
$cart->fill($cartItemCollection);
$cart->setShipping($shipping);
$cart->setPayment($payment);

$discountedCart = new SecondItemFreeDiscount($cart, new CartDiscount);
$discountedCart = new TotalPriceThresholdDiscount($discountedCart, new CartDiscount, ['threshold' => 50, 'discount' => 0.05]);

/*
echo 'Total items: ' . $discountedCart->totalItems() . "\n\n";
echo 'Total: ' . $discountedCart->total() . "\n\n";
echo 'Total tax: ' . $discountedCart->totalTax() . "\n\n";
echo 'Shipping cost: ' . $discountedCart->shippingCost() . "\n\n";
echo 'Payment fee: ' . $discountedCart->paymentFee() . "\n\n";
*/

echo '<pre>';
var_dump($cart->toArray());
