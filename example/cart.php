<?php

require_once __DIR__ . '/../vendor/autoload.php'; // Autoload files using Composer autoload

use Plane\Shop\Cart;
use Plane\Shop\CartItem;
use Plane\Shop\Product;
use Plane\Shop\Payment;
use Plane\Shop\Shipping;
use Plane\Shop\CartItemCollection;

use Plane\Shop\PriceFormat\EnglishFormat;

use Plane\Shop\Discount\SecondItemFreeDiscount;
use Plane\Shop\Discount\TotalPriceThresholdDiscount;

$product1 = new Product([
    'id'        => 1,
    'name'      => 'Product One',
    'price'     => 10,
    'taxRate'   => 0.2
]);

$product2 = new Product([
    'id'        => 2,
    'name'      => 'Product Two',
    'price'     => 4.00,
    'taxRate'   => 0.2
]);

$cartItemCollection = new CartItemCollection;
$cartItemCollection->addItem(new CartItem($product1, 4));
$cartItemCollection->addItem(new CartItem($product2, 1));

$priceFormat = new EnglishFormat();

$shipping = new Shipping([
   'id'             => 9,
   'name'           => 'National Shipping Company',
   'description'    => 'Standart Ground Shipping',
   'cost'           => 15
]);

$payment = new Payment([
   'id'             => 1,
   'name'           => 'PayPal',
   'description'    => 'Payment with Paypal',
   'fee'            => 5
]);

$cart = new Cart($priceFormat);
$cart->fill($cartItemCollection);
$cart->setShipping($shipping);
$cart->setPayment($payment);

$discount1 = new SecondItemFreeDiscount($cart, [
    'name' => 'Second item will be free',
    'description' => 'Some description'
]);

$discount2 = new TotalPriceThresholdDiscount($discount1, [
    'name' => 'To percent off on discount',
    'description' => '10% off on orders equal or above 40',
    'threshold' => 40,
    'discount' => 0.10
]);

echo 'Total items: ' . $discount2->totalItems() . "\n\n";
echo 'Total: ' . $discount2->total() . "\n\n";
echo 'Total tax: ' . $discount2->totalTax() . "\n\n";
echo 'Shipping cost: ' . $discount2->shippingCost() . "\n\n";
echo 'Payment fee: ' . $discount2->paymentFee() . "\n\n";
echo 'Total after discounts: ' . $discount2->totalAfterDisconuts() . "\n\n";


