<?php

namespace Plane\Shop\PriceFormat;

/**
 * English notation price format (1234.57)
 *
 * @author Dariusz Korsak <dkorsak@gmail.com>
 * @package Plane\Shop;
 */
class EnglishFormat implements PriceFormatInterface
{
    /**
     * Price format
     * @var string
     */
    private $format = '%.2n';
    
    /**
     * Format price
     * @param int|float $price
     * @return float
     */
    public function formatPrice($price)
    {
        return (float) money_format($this->format, (float) $price);
    }
}
