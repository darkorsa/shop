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

interface CartPresenterInterface extends CartCommonInterface
{
    public function totalNet(): string;
    
    public function totalGross(): string;
    
    public function tax(): string;
    
    public function totalAfterDiscounts(): string;
    
    public function shippingCost(): string;
    
    public function paymentFee(): string;

    public function toArray(): array;
}
