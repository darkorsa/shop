# shop

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]
[![Total Downloads][ico-downloads]][link-downloads]

The shopping cart is present in practically every online store. This library is a convenient to use implementation of the shopping cart with the following features:

- prices calculation (gross/net)
- tax calculation
- multiple price formats
- shipping costs
- payment costs
- customized discounts
- stock validation
- increasing/decreasing items quantity

Also you do not have to worry about the correctness of operations on the amounts of money, this is carried out with the help of the [Money for PHP](http://moneyphp.org/en/stable) library  which is the implementation of the Money pattern by Martin Fowler. 

Package is PSR-2 and PSR-4 compliant.

## Install

Via Composer

``` bash
$ composer require darkorsa/shop
```

## Usage

A few steps are required to create a cart object.

### Products

Products represent the goods sold in the shop. The required parameters are:

- id
- name
- stock (how much of that product is available on stock)
- price
- taxRate

optional params:

- weight
- imagePath

``` php
use Plane\Shop\Product;

$someProduct = new Product([
    'id'        => '1',
    'name'      => 'Some product',
    'stock'     => 8,
    'price'     => 2.8,
    'taxRate'   => 0.10,
]);
```

If you need to include additional product data in your shopping cart, you can extend Product functionality by using the decorator pattern.

### Cart items

Cart items represent the content of the shopping cart. Items can be injected into Cart object one by one or with use of collection.

``` php
use Plane\Shop\CartItem;
use Plane\Shop\CartItemCollection;

$firstCartItem = new CartItem($someProduct); // cart item with 1 product
$secondCartItem = new CartItem($someOtherProduct, 4); // cart item with 4 products

$cartItemCollection = new CartItemCollection;

$cartItemCollection->addItem($firstCartItem);
$cartItemCollection->addItem($secondCartItem);
```

To ensure that the amount of products in the cart is not greater than the amount in stock, a validator can be used.

``` php
use Plane\Shop\Exception\QuanityException;
use Plane\Shop\Validator\StockQuantityValidator;

try {
    $cartItem = new CartItem($someProduct, 10, new StockQuantityValidator));
} catch (QuanityException $e) {
    // handle exception
}
```

Validation also takes place when you add an item to the Cart. When the same item is added again (i.e. an item with the same product ID), the item is not added twice, but it's quantity is incremented.

``` php
try {
    $cart->add($cartItem);
    $cart->add($cartItem); // if sum of items exceeds product stock an exception is thrown
} catch (QuanityException $e) {
    // handle exception
}
```


### Shipping

Shipping can be defined so the shipping data will be available within the Cart object.

``` php
use Plane\Shop\Shipping;

$shipping = new Shipping([
   'id'             => 1,
   'name'           => 'National Shipping Company',
   'description'    => 'Standart Ground Shipping',
   'cost'           => 7.50,
]);
```

### Payment

Payment can be defined in order to calculate payment fee. There are two methods of fee calculation. Fixed price and percentage.

``` php
use Plane\Shop\Payment;

// fixed price
$payment = new Payment([
   'id'             => 1,
   'name'           => 'PayPal',
   'description'    => 'Payment with Paypal',
   'fee'            => 8.45
]);

// percentage of the total gross price after discounts
$payment = new Payment([
   'id'             => 1,
   'name'           => 'PayPal',
   'description'    => 'Payment with Paypal',
   'fee'            => 2 // 2%
], Payment::FEE_PERCENTAGE);
```

### Cart

Cart is an object representing a shopping cart and provides all the necessary methods to manage it or obtain calculated data.

#### Creation

``` php
use Plane\Shop\Cart;

$cart = new Cart('USD');
$cart->fill($cartItemCollection); // fill cart with many items at once
$cart->add($cartItem); // add single cart item
```

Currency must be in ISO standard.

#### Usage

``` php
echo $cart->itemsQuantity(); // total quantity of cart items
echo $cart->totalNet(); // total net price
echo $cart->totalGross(); // total gross price
echo $cart->tax() // sum of taxes for all items;
echo $cart->weight(); // total items weight
echo $cart->shippingCost() // shipping cost;
echo $cart->paymentFee(); // payment fee (percentage or fixed)
echo $cart->totalAfterDiscounts(); // total gross price after applying all discounts
```

Note that all prices are represented as [Money](https://github.com/moneyphp/money/blob/master/src/Money.php) object.

#### Discounts

Discount can be applied to the Cart object. This library comes with  2 predefined discounts, however custom discounts can be applied as well.

- TotalPriceThresholdDiscount - the discount will be applied when the total price exceeds a certain price threshold
- EverySecondItemFreeDiscount - every second cart item is free

Discount example:

``` php
use Plane\Shop\CartDiscount;
use Plane\Shop\Discount\TotalPriceThresholdDiscount;

$discount = new CartDiscount('Discount description');

$discountedCart = new TotalPriceThresholdDiscount($cart, $discount, ['treshold' => 160, 'discount' => 0.1]); // ten percent discount for total gross price above 160
```

#### Presenation

By default the prices are returned as  [Money](https://github.com/moneyphp/money/blob/master/src/Money.php) object but one can easly format all the prices within Cart with use of CartPresenter.

##### Default formatter

Default formatter is [Decimal Formatter](http://moneyphp.org/en/stable/features/formatting.html#decimal-formatter).

``` php
use Plane\Shop\CartPresenter;

$cartPresenter = new CartPresenter($cart);

echo $cartPresenter->totalNet(); // 10.00
echo $cartPresenter->totalGross(); // 10.22
echo $cartPresenter->tax(); // 0.22

```

##### Other formatters

One can use other formatters shipped with [Money for PHP](http://moneyphp.org/en/stable) library or write own custom formmatter.

``` php
use Money\Currencies\ISOCurrencies;
use Money\Formatter\IntlMoneyFormatter;

$numberFormatter = new \NumberFormatter('us_US', \NumberFormatter::CURRENCY);
$moneyFormatter = new IntlMoneyFormatter($numberFormatter, new ISOCurrencies());

$cartPresenter = new CartPresenter($cart, $moneyFormatter);

echo $cartPresenter->totalNet(); // $10.00
echo $cartPresenter->totalGross(); // $10.22
echo $cartPresenter->tax(); // $0.22
```

##### Cart data

To obtain all the cart data like prices, items, products, shipping details, payment, etc. *toArray* method can be used.

This data can then be passed on to the presentation layers or as an API response.

``` php
$cartData = $cartPresenter->toArray();
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
