<?php

require_once __DIR__ . '/../vendor/autoload.php'; // Autoload files using Composer autoload

use Plane\Shop\Cart;
use Plane\Shop\Payment;
use Plane\Shop\Product;
use Plane\Shop\CartItem;
use Plane\Shop\Shipping;
use Plane\Shop\CartDiscount;
use Plane\Shop\CartItemCollection;
use Plane\Shop\Discount\EverySecondItemFreeDiscount;
use Plane\Shop\Discount\TotalPriceThresholdDiscount;
use Plane\Shop\Validator\StockQuantityValidator;
use Plane\Shop\CartPresenter;

$product1 = new Product([
    'id'        => 1,
    'name'      => 'Product One',
    'quantity'  => 8,
    'price'     => 10,
    'taxRate'   => 0.10,
]);

$product2 = new Product([
    'id'        => 2,
    'name'      => 'Product Two',
    'quantity'  => 6,
    'price'     => 25,
    'taxRate'   => 0.10,
]);

try {
    $cartItemCollection = new CartItemCollection;
    $cartItemCollection->addItem(new CartItem($product1, 5, new StockQuantityValidator));
    $cartItemCollection->addItem(new CartItem($product2, 2, new StockQuantityValidator));
} catch (Exception $e) {
    echo $e->getMessage() . PHP_EOL;
    die;
}


$shipping = new Shipping([
   'id'             => 9,
   'name'           => 'National Shipping Company',
   'description'    => 'Standart Ground Shipping',
   'cost'           => 0,
]);

$payment = new Payment([
   'id'             => 1,
   'name'           => 'PayPal',
   'description'    => 'Payment with Paypal',
   'fee'            => 0.10
]);
$payment->setPercentage();

$cart = new Cart('PLN');
$cart->fill($cartItemCollection);
$cart->setShipping($shipping);
$cart->setPayment($payment);

$cartDisount1 = new TotalPriceThresholdDiscount(
    $cart,
    new CartDiscount('Jest to opis jakiegos discouta'),
    ['treshold' => 160, 'discount' => 0.1]
);

/*$cartDisount2 = new EverySecondItemFreeDiscount(
    $cartDisount1,
    new CartDiscount('Co drugi free!')
);*/

$presentator = new CartPresenter($cartDisount1);

//var_dump($presentator->toArray());
//exit;

echo 'Total items: ' . $presentator->itemsQuantity() . "\n\n";
echo 'Total net: ' . $presentator->totalNet() . "\n\n";
echo 'Total gross: ' . $presentator->totalGross() . "\n\n";
echo 'Total tax: ' . $presentator->tax() . "\n\n";
echo 'Total weight: ' . $presentator->weight() . "\n\n";
echo 'Shipping cost: ' . $presentator->shippingCost() . "\n\n";
echo 'Payment fee: ' . $presentator->paymentFee() . "\n\n";
echo 'Total after discounts: ' . $presentator->totalAfterDiscounts() . "\n\n";


