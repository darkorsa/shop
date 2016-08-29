<?php

namespace Plane\Shop\Validator;

use Plane\Shop\ProductInterface as Product;

/**
 * Interface for QuantityValidators
 *
 * @author Dariusz Korsak <dkorsak@gmail.com>
 * @package Plane\Shop
 */
interface QuantityValidatorInterface
{
    public function validate(Product $product, $quantity);
}
