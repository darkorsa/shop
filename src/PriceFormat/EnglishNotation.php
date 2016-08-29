<?php

namespace Plane\Shop\PriceFormat;

/**
 * English notation price format (1234.57)
 *
 * @author Dariusz Korsak <dkorsak@gmail.com>
 * @package Plane\Shop;
 */
class EnglishNotation extends PriceFormatAbstract
{
    protected $decimals = 2;
    
    protected $decPoint = '.';
    
    protected function formatPrice($price)
    {
        return number_format((float) $price, $this->decimals, $this->decPoint, '');
    }
}
