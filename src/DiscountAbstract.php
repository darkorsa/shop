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

use Plane\Shop\CartDiscount;
use Plane\Shop\CartInterface;

abstract class DiscountAbstract
{
    protected $cart;
    
    protected $cartDiscount;
    
    public function __construct(CartInterface $cart, CartDiscount $cartDiscount, array $config = [])
    {
        $this->cart = $cart;
        $this->cartDiscount = $cartDiscount;

        // waiting for typed properties in PHP 7.4
        foreach ($config as $property => $value) {
            $this->$property = $value;
        }
        
        $this->applyDiscount();
    }
    
    abstract protected function applyDiscount(): void;
}
