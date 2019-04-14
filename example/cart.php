<?php

require_once __DIR__ . '/../vendor/autoload.php'; // Autoload files using Composer autoload

use Plane\Shop\Cart;
use Plane\Shop\Payment;
use Plane\Shop\Product;
use Plane\Shop\CartItem;
use Plane\Shop\Shipping;
use Plane\Shop\CartPresenter;
use Plane\Shop\CartItemCollection;
use Money\Currencies\ISOCurrencies;
use Money\Formatter\IntlMoneyFormatter;
use Plane\Shop\Validator\StockQuantityValidator;
use Plane\Shop\Discount\EverySecondItemFreeDiscount;
use Plane\Shop\Discount\TotalPriceThresholdDiscount;

$product1 = new Product([
    'id'        => '1_a',
    'name'      => 'Product One',
    'stock'     => 8,
    'price'     => 10,
    'taxRate'   => 0.10,
]);

$product2 = new Product([
    'id'        => '2_a',
    'name'      => 'Product Two',
    'stock'     => 6,
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
   'fee'            => 12
]);

$cart = new Cart('USD');
$cart->fill($cartItemCollection);
$cart->setShipping($shipping);
$cart->setPayment($payment);

// first discount
$secondFreeDisount = new EverySecondItemFreeDiscount('Every second product is free', $cart, [
    'items' => $cart->items()
]);
$cart->addDiscount($secondFreeDisount);

// second discount
$priceTresholdDiscount = new TotalPriceThresholdDiscount('Treshold disconut', $cart, [
    'treshold' => 100,
    'discount' => 0.1
]);
$cart->addDiscount($priceTresholdDiscount);

$numberFormatter = new \NumberFormatter('us_US', \NumberFormatter::CURRENCY);
$moneyFormatter = new IntlMoneyFormatter($numberFormatter, new ISOCurrencies());

$presentator = new CartPresenter($cart, $moneyFormatter);

echo 'Total items: ' . $presentator->itemsQuantity() . "\n\n";
echo 'Total net: ' . $presentator->totalNet() . "\n\n";
echo 'Total gross: ' . $presentator->totalGross() . "\n\n";
echo 'Total tax: ' . $presentator->tax() . "\n\n";
echo 'Total weight: ' . $presentator->weight() . "\n\n";
echo 'Shipping cost: ' . $presentator->shippingCost() . "\n\n";
echo 'Payment fee: ' . $presentator->paymentFee() . "\n\n";
echo 'Total after discounts: ' . $presentator->totalAfterDiscounts() . "\n\n";


