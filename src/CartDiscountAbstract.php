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

abstract class CartDiscountAbstract implements CartDiscountInterface
{
    protected $price;

    protected $currency;
    
    protected $description;

    protected $priceAfterDiscount;

    public function __construct(string $description, CartInterface $cart, array $config = [])
    {
        $this->description  = $description;
        $this->price        = $cart->totalAfterDiscounts();
        $this->currency     = $cart->getCurrency();

        foreach ($config as $property => $value) {
            $this->$property = $value;
        }
        
        $this->applyDiscount();
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getPriceAfterDiscount(): Money
    {
        return $this->priceAfterDiscount;
    }

    abstract protected function applyDiscount(): void;
}
