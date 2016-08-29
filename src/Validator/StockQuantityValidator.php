<?php

namespace Plane\Shop\Validator;

use Plane\Shop\ProductInterface as Product;

/**
 * Description of StockQuantityValidator
 *
 * @author Dariusz Korsak <dkorsak@gmail.com>
 * @package Plane\Shop;
 */
class StockQuantityValidator implements QuantityValidatorInterface
{
    public function validate(Product $product, $quantity)
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
