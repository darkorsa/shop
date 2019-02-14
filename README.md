# shop

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]
[![Total Downloads][ico-downloads]][link-downloads]

The shopping cart is present in practically every online store. This library is a convenient to use implementation of the shopping cart with the following features:

- calculation of the total price of the order
- tax calculation
- variable price formats
- shipping costs
- payment costs
- customized discounts
- stock validation
- increasing / decreasing items quantity

Also you do not have to worry about the correctness of operations on the amounts of money, this is carried out with the help of the Money for PHP library (http://moneyphp.org/en/stable) which is the implementation of the Money pattern by Martin Fowler. 

Package is PSR-2 and PSR-4 compliant.

## Install

Via Composer

``` bash
$ composer require darkorsa/shop
```

## Usage

A few steps are required to create a cart object.

### Products

The products represent the goods sold in the shop. The required parameters are:

- id
- name
- stock (how much of that product is available on stock)
- price
- taxRate

optional params:

- weight
- imagePath

Excemple:

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

If you need to include additional product data in your shopping cart, you can extend its functionality by using the decorator pattern.


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
