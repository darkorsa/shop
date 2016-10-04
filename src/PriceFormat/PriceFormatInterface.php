<?php

namespace Plane\Shop\PriceFormat;

/**
 * Inferface for price formatting classes
 *
 * @author Dariusz Korsak <dkorsak@gmail.com>
 * @package Plane\Shop
 */
interface PriceFormatInterface
{
    /**
     * Format price
     * @param int|float $price
     * @return float
     */
    public function formatPrice($price);
}
