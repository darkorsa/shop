<?php

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

class Payment implements PaymentInterface
{
    const FEE_FIXED = 'fixed';
    
    const FEE_PERCENTAGE = 'percentage';
    
    private $id;
    
    private $name;
    
    private $description;
    
    private $fee;
    
    private $feeType = self::FEE_FIXED;

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
    
    public function setFixed(): void
    {
        $this->feeType = self::FEE_FIXED;
    }
    
    public function setPercentage(): void
    {
        $this->feeType = self::FEE_PERCENTAGE;
    }
    
    public function getFee(Money $totalPrice, string $currency): Money
    {
        if ($this->feeType == self::FEE_PERCENTAGE) {
            return $totalPrice->multiply($this->fee);
        }

        $moneyParser = new DecimalMoneyParser(new ISOCurrencies());
        
        return $moneyParser->parse((string) $this->fee, new Currency($currency));
    }
}
