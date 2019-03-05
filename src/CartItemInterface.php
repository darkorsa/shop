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
use Plane\Shop\ProductInterface;

interface CartItemInterface
{
    public function getProduct(): ProductInterface;
    
    public function getId(): string;
        
    public function getName(): string;
    
    public function getQuantity(): int;
    
    public function getImagePath(): string;
    
    public function setQuantity(int $quantity): void;
    
    public function increaseQuantity(int $quantity): void;
    
    public function decreaseQuantity(int $quantity): void;
        
    public function getWeight(): float;
    
    public function getWeightTotal(): float;
    
    public function getTax(string $currency): Money;
    
    public function getTaxTotal(string $currency): Money;
    
    public function getPrice(string $currency): Money;
    
    public function getPriceTotal(string $currency): Money;

    public function getPriceWithTax(string $currency): Money;
    
    public function getPriceTotalWithTax(string $currency): Money;
    
    public function toArray(string $currency): array;
}
