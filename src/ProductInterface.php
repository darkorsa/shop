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

interface ProductInterface
{
    public function getId(): string;
    
    public function getName(): string;

    public function getStock(): int;

    public function setPrice(float $price): void;

    public function getPrice(string $currency): Money;
    
    public function getTaxRate(): float;
    
    public function getTax(string $currency): Money;
    
    public function getPriceWithTax(string $currency): Money;

    public function getWeight(): string;

    public function getImagePath(): string;
    
    public function toArray(string $currency): array;
}
