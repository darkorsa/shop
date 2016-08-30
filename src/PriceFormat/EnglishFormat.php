<?php

namespace Plane\Shop\PriceFormat;

/**
 * English notation price format (1234.57)
 *
 * @author Dariusz Korsak <dkorsak@gmail.com>
 * @package Plane\Shop;
 */
class EnglishFormat extends PriceFormatAbstract
{
    protected $decimals = 2;
    
    protected $decPoint = '.';
    
    protected function formatPrice($price)
    {
        return number_format(floor((float) $price * 100) / 100, $this->decimals, $this->decPoint, '');
    }
}
