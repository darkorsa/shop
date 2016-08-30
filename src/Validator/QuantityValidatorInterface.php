<?php

namespace Plane\Shop\Validator;

use Plane\Shop\ProductInterface;

/**
 * Interface for QuantityValidators
 *
 * @author Dariusz Korsak <dkorsak@gmail.com>
 * @package Plane\Shop
 */
interface QuantityValidatorInterface
{
    public function validate(ProductInterface $product, $quantity);
}
