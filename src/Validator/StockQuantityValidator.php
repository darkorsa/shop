<?php declare(strict_types=1);

/*
 * This file is part of the Plane\Shop package.
 *
 * (c) Dariusz Korsak <dkorsak@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Plane\Shop\Validator;

use Plane\Shop\ProductInterface;

class StockQuantityValidator implements QuantityValidatorInterface
{
    public function validate(ProductInterface $product, int $quantity): bool
    {
        if ($product->getQuantity() < (int) $quantity) {
            return false;
        }
        
        if ($quantity <= 0) {
            return false;
        }
        
        return true;
    }
}
