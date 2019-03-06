<?php declare(strict_types=1);

/*
 * This file is part of the Plane\Shop package.
 *
 * (c) Dariusz Korsak <dkorsak@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Plane\Shop\Traits;

use Money\Money;

trait CartPrices
{
    public function totalNet(): Money
    {
        return $this->cart->totalNet();
    }

    public function totalGross(): Money
    {
        return $this->cart->totalGross();
    }
    
    public function tax(): Money
    {
        return $this->cart->tax();
    }
    
    public function totalAfterDiscounts(): Money
    {
        return $this->cart->totalAfterDiscounts();
    }
    
    public function shippingCost(): Money
    {
        return $this->cart->shippingCost();
    }
    
    public function paymentFee(): Money
    {
        return $this->cart->paymentFee();
    }
}
