<?php

namespace Plane\Shop;

use InvalidArgumentException;
use Plane\Shop\CartItemCollection;

/**
 * Description of CartItemsDecorator
 *
 * @author Dariusz Korsak <dkorsak@gmail.com>
 */
class CartItemsDecorator
{
    private $collection;
    
    private $decorator;
    
    public function __construct(CartItemCollection $collection, $decorator)
    {
        if (!class_exists($decorator)) {
            throw new InvalidArgumentException("Decorator class $decorator does not exist");
        }
        
        $this->collection = $collection;
        $this->decorator = $decorator;
    }
    
    public function decorate()
    {
        foreach ($this->collection->keys() as $key) {
            $this->collection->replaceItem(new $this->decorator($this->collection->getItem($key)), $key);
        }
    }
}
