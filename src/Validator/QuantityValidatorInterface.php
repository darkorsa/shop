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
    /**
     * Validate quantity
     * @param \Plane\Shop\ProductInterface $product
     * @param int $quantity
     * @return boolean
     */
    public function validate(ProductInterface $product, $quantity);
}
