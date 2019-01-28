<?php

namespace Plane\Shop;

use Plane\Shop\PriceFormat\PriceFormatInterface;

/**
 * Description of Shipping
 *
 * @author Dariusz Korsak <dkorsak@gmail.com>
 * @package Plane/Shop
 */
class Shipping implements ShippingInterface
{
    /**
     * Shippint id
     * @var int
     */
    private $id;
    
    /**
     * Shippint name
     * @var string
     */
    private $name;
    
    /**
     * Shipping description
     * @var string
     */
    private $description;
    
    /**
     * Shipping cost
     * @var float
     */
    private $cost;
    
    /**
     * Price format object
     * @var \Plane\Shop\PriceFormat\PriceFormatInterface
     */
    private $priceFormat;
    
    /**
     * Constructor
     * @param array $data
     */
    public function __construct(array $data)
    {
        foreach ($data as $k => $v) {
            $this->$k = $v;
        }
    }
    
    /**
     * Return id
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * Return name
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
    
    /**
     * Return description
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }
    
    /**
     * Return cost
     * @return float
     */
    public function getCost()
    {
        if (!is_null($this->priceFormat)) {
            return $this->priceFormat->formatPrice($this->cost);
        }
        
        return (float) $this->cost;
    }
    
    /**
     * Set cost
     * @param int|float $cost
     */
    public function setCost($cost)
    {
        $this->cost = (float) $cost;
    }
    
    /**
     * Set price format object
     * @param \Plane\Shop\PriceFormat\PriceFormatInterface $priceFormat
     */
    public function setPriceFormat(PriceFormatInterface $priceFormat)
    {
        $this->priceFormat = $priceFormat;
    }
}
