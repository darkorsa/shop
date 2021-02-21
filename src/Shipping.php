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
use InvalidArgumentException;
use Money\Currencies\ISOCurrencies;
use Money\Parser\DecimalMoneyParser;

class Shipping implements ShippingInterface
{
    private $id;
    
    private $name;
    
    private $description;
    
    private $cost;

    private $requiredFields = [
        'id',
        'name',
        'cost',
    ];

    public function __construct(array $data)
    {
        if (count(array_intersect_key(array_flip($this->requiredFields), $data)) !== count($this->requiredFields)) {
            throw new InvalidArgumentException(
                'Cannot create object, required array keys: '. implode(', ', $this->requiredFields)
            );
        }
        
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
    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'desc' => $this->getDescription(),
        ];
    }
}
