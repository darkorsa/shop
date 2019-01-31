<?php declare(strict_types=1);

/*
 * This file is part of the Plane\Shop package.
 *
 * (c) Dariusz Korsak <dkorsak@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Plane\Shop;

use Money\Money;

class CartDiscount
{
    private $discountText;

    private $priceAfterDiscount;

    public function __construct(string $text)
    {
        $this->discountText = $text;
    }

    public function getDiscountText(): string
    {
        return $this->discountText;
    }

    public function setPriceAfterDiscount(Money $price): void
    {
        $this->priceAfterDiscount = $price;
    }

    public function getPriceAfterDiscount(): Money
    {
        return $this->priceAfterDiscount;
    }
}
