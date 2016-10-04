<?php

namespace Plane\Shop\Validator;

use Plane\Shop\ProductInterface;

/**
 * StockQuantityValidator prevents from setting quantity above stock or below 0
 *
 * @author Dariusz Korsak <dkorsak@gmail.com>
 * @package Plane\Shop;
 */
class StockQuantityValidator implements QuantityValidatorInterface
{
    /**
     * Validate quantity
     * @param \Plane\Shop\ProductInterface $product
     * @param int $quantity
     * @return boolean
     */
    public function validate(ProductInterface $product, $quantity)
    {
        if ($product->getQuantity() < (int) $quantity) {
            return false;
        }
        
        if ($quantity < 0) {
            return false;
        }
        
        return true;
    }
}
