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
    'price'     => 10,
    'imagePath' => '/resources/singles/commander.jpg',
    'taxRate'   => 0.0
]);

$product2 = new Product([
    'id'        => 2,
    'name'      => 'Wall of Blossoms',
    'price'     => 4.00,
    'imagePath' => '/resources/singles/wall.jpg',
    'taxRate'   => 0.0
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
   'fee'            => 5
]);

$cart = new Cart($priceFormat);
$cart->fill($cartItemCollection);
$cart->setShipping($shipping);
$cart->setPayment($payment);

$discount1Cart = new SecondItemFreeDiscount(
    $cart,
    ['name' => 'Second item will be free',
    'description' => 'Some description']
);
$discount2Cart = new TotalPriceThresholdDiscount(
    $discount1Cart,
    [
    'name' => 'To percent off on discount',
    'description' => '10% off on orders equal or above 40',
    'threshold' => 40,
    'discount' => 0.10
    ]
);


echo 'Total items: ' . $discount2Cart->totalItems() . "\n\n";
echo 'Total: ' . $discount2Cart->total() . "\n\n";
echo 'Total tax: ' . $discount2Cart->totalTax() . "\n\n";
echo 'Shipping cost: ' . $discount2Cart->shippingCost() . "\n\n";
echo 'Payment fee: ' . $discount2Cart->paymentFee() . "\n\n";
echo 'Total after discounts: ' . $discount2Cart->totalAfterDisconuts() . "\n\n";


