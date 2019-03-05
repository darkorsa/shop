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

final class Product implements ProductInterface
{
    private $id;
    
    private $name;

    private $stock;
    
    private $price;

    private $taxRate;
    
    private $weight;
    
    private $imagePath;

    private $requiredFields = [
        'id',
        'name',
        'price',
        'stock',
        'taxRate'
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
    
    public function getId(): string
    {
        return $this->id;
    }
    
    public function getName(): string
    {
        return $this->name;
    }

    public function getStock(): int
    {
        return $this->stock;
    }

    public function getPrice(string $currency): Money
    {
        $moneyParser = new DecimalMoneyParser(new ISOCurrencies());
        
        return $moneyParser->parse((string) $this->price, new Currency($currency));
    }
    
    public function getTaxRate(): float
    {
        return $this->taxRate;
    }
    
    public function getTax(string $currency): Money
    {
        return $this->getPrice($currency)->multiply($this->taxRate);
    }
    
    public function getPriceWithTax(string $currency): Money
    {
        return $this->getPrice($currency)->add($this->getTax($currency));
    }

    public function getWeight(): float
    {
        return (float) $this->weight;
    }
    
    public function getImagePath(): string
    {
        return (string) $this->imagePath;
    }
    
    public function toArray(string $currency): array
    {
        $array = [];
        $array['id']                = $this->getId();
        $array['name']              = $this->getName();
        $array['price']             = $this->getPrice($currency);
        $array['stock']             = $this->getStock();
        $array['taxRate']           = $this->getTaxRate();
        $array['tax']               = $this->getTax($currency);
        $array['priceWithTax']      = $this->getPriceWithTax($currency);
        $array['weight']            = $this->getWeight();
        $array['imagePath']         = $this->getImagePath();

        return $array;
    }
}
