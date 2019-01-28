# shop

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]
[![Total Downloads][ico-downloads]][link-downloads]

This package includes full shop experience including support for discounts, price formats, and stock validators. 
Package is PSR-4 compliant.

## Install

Via Composer

``` bash
$ composer require darkorsa/shop
```

## Usage

``` php
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
...
```

## Security

If you discover any security related issues, please email dkorsak@gmail.com instead of using the issue tracker.

## Credits

- [Dariusz Korsak][link-author]
- [All Contributors][link-contributors]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/darkorsa/shop.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/darkorsa/shop/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/darkorsa/shop.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/darkorsa/shop.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/darkorsa/shop.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/darkorsa/shop
[link-travis]: https://travis-ci.org/darkorsa/shop
[link-scrutinizer]: https://scrutinizer-ci.com/g/darkorsa/shop/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/darkorsa/shop
[link-downloads]: https://packagist.org/packages/darkorsa/shop
[link-author]: https://github.com/darkorsa
[link-contributors]: ../../contributors
