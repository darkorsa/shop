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
     * Number of decimals after decimal point
     * @var int
     */
    private $decimals = 2;
    
    /**
     * Decimap point
     * @var string
     */
    private $decPoint = '.';
    
    /**
     * Format price
     * @param int|float $price
     * @return float
     */
    public function formatPrice($price)
    {
        return (float) number_format(floor((float) $price * 100) / 100, $this->decimals, $this->decPoint, '');
    }
}
