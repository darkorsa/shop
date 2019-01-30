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

class Product implements ProductInterface
{
    protected $id;
    
    protected $name;
    
    protected $price;
    
    protected $weight;
    
    protected $quantity;
    
    protected $imagePath;
    
    protected $taxRate;
    
    public function __construct(array $data)
    {
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

    public function setPrice(float $price): void
    {
        $this->price = $price;
    }

    public function getPrice(string $currency): Money
    {
        $moneyParser = new DecimalMoneyParser(new ISOCurrencies());
        
        return $moneyParser->parse((string) $this->price, new Currency($currency));
    }
    
    public function getWeight(): float
    {
        return $this->weight;
    }
    
    public function getQuantity(): int
    {
        return (int) $this->quantity;
    }
    
    public function getImagePath(): string
    {
        return $this->imagePath;
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
    
    public function toArray(string $currency): array
    {
        $array = [];
        $array['id']                = $this->getId();
        $array['name']              = $this->getName();
        $array['imagePath']         = $this->getImagePath();
        $array['quantity']          = $this->getQuantity();
        $array['taxRate']           = $this->getTaxRate();
        $array['tax']               = $this->getTax($currency);
        $array['price']             = $this->getPrice($currency);
        $array['weight']            = $this->getWeight();
        $array['priceWithTax']      = $this->getPriceWithTax($currency);

        return $array;
    }
}
