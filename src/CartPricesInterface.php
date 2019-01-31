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

interface CartPricesInterface
{
    public function totalNet(): Money;
    
    public function totalGross(): Money;
    
    public function tax(): Money;
    
    public function totalAfterDiscounts(): Money;
    
    public function shippingCost(): Money;
    
    public function paymentFee(): Money;
}
