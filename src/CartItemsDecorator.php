<?php

namespace Plane\Shop;

use InvalidArgumentException;

/**
 * Decorator class form CartItems objects
 *
 * @author Dariusz Korsak <dkorsak@gmail.com>
 */
class CartItemsDecorator
{
    /**
     * Collection of CartItem objects
     * @var \Plane\Shop\CartItemCollection
     */
    private $collection;
    
    /**
     * Decorator for CartItem object
     * @var \Plane\Shop\CartItemInterface
     */
    private $decorator;
    
    /**
     * Class constructor
     * @param \Plane\Shop\CartItemCollection $collection
     * @param \Plane\Shop\CartItemInterface $decorator
     * @throws \InvalidArgumentException
     */
    public function __construct(CartItemCollection $collection, CartItemInterface $decorator)
    {
        if (!class_exists($decorator)) {
            throw new InvalidArgumentException("Decorator class $decorator does not exist");
        }
        
        $this->collection = $collection;
        $this->decorator = $decorator;
    }
    
    /**
     * Decorate collection items
     */
    public function decorate()
    {
        foreach ($this->collection->keys() as $key) {
            $this->collection->replaceItem(new $this->decorator($this->collection->getItem($key)), $key);
        }
    }
}
