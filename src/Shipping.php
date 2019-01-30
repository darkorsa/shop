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
use Money\Currency;
use Money\Currencies\ISOCurrencies;
use Money\Parser\DecimalMoneyParser;

class Shipping implements ShippingInterface
{
    private $id;
    
    private $name;
    
    private $description;
    
    private $cost;

    public function __construct(array $data)
    {
        // waiting for typed properties in PHP 7.4
        foreach ($data as $property => $value) {
            $this->$property = $value;
        }
    }
    
    public function getId(): int
    {
        return $this->id;
    }
    
    public function getName(): string
    {
        return $this->name;
    }
    
    public function getDescription(): string
    {
        return $this->description;
    }
    
    public function getCost(string $currency): Money
    {
        $moneyParser = new DecimalMoneyParser(new ISOCurrencies());
        
        return $moneyParser->parse((string) $this->cost, new Currency($currency));
    }
    
    public function setCost(float $cost): void
    {
        $this->cost = $cost;
    }
}
