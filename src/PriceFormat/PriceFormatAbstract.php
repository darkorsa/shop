<?php

namespace Plane\Shop\PriceFormat;

use BadMethodCallException;

/**
 * Abstract class for price format
 *
 * @author Dariusz Korsak <dkorsak@gmail.com>
 * @package Plane\Shop;
 */
abstract class PriceFormatAbstract implements PriceInterface
{
    protected $price;
    
    public function __construct(PriceInterace $price)
    {
        $this->price = $price;
    }
    
    public function getTax()
    {
        return $this->formatPrice($this->price->getTax());
    }
    
    public function getTaxTotal()
    {
        return $this->formatPrice($this->price->getTaxTotal());
    }
    
    public function getPrice()
    {
        return $this->formatPrice($this->price->getPrice());
    }
    
    public function getPriceWithTax()
    {
        return $this->formatPrice($this->price->getPriceWithTax());
    }
    
    public function getPriceTotal()
    {
        return $this->formatPrice($this->price->getPriceTotal());
    }
    
    public function getPriceTotalWithTax()
    {
        return $this->formatPrice($this->price->getPriceTotalWithTax());
    }
    
    public function __call($method, $args)
    {
        if (is_callable(array($this->price, $method))) {
            return call_user_func_array(array($this->price, $method), $args);
        } else {
            throw new BadMethodCallException('Undefined method ' .get_class($this->price) . '::' . $method . '() called');
        }
    }
    
    abstract protected function formatPrice($price);
}
