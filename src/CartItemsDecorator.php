<?php

/*
 * This file is part of the Plane\Shop package.
 *
 * (c) Dariusz Korsak <dkorsak@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Plane\Shop;

use InvalidArgumentException;
use Plane\Shop\CartItemInterface;

class CartItemsDecorator
{
    private $collection;
    
    private $decorator;
    
    public function __construct(array $collection, string $decoratorClass)
    {
        if (!class_exists($decoratorClass)) {
            throw new InvalidArgumentException("Decorator class {$decoratorClass} does not exist");
        }

        $decorator = new $decoratorClass();

        if (!$decorator instanceof CartItemInterface) {
            throw new InvalidArgumentException("Decorator class {$decoratorClass} doesn't implement CartItemInterface");
        }
        
        $this->collection = $collection;
        $this->decorator = $decorator;
    }
    
    public function decorate(): void
    {
        foreach ($this->collection->keys() as $key) {
            $this->collection->replaceItem(new $this->decorator($this->collection->getItem($key)), $key);
        }
    }
}
