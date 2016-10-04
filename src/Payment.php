<?php

namespace Plane\Shop;

use Plane\Shop\PriceFormat\PriceFormatInterface;

/**
 * Payment class
 *
 * @author Dariusz Korsak <dkorsak@gmail.com>
 * @package Plane\Shop
 */
class Payment implements PaymentInterface
{
    /**
     * Payment id
     * @var int
     */
    private $id;
    
    /**
     * Payment name
     * @var sting
     */
    private $name;
    
    /**
     * Payment description
     * @var string
     */
    private $description;
    
    /**
     * Payment fee
     * @var int|float
     */
    private $fee;
    
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
     * Return fee
     * @return float|int
     */
    public function getFee()
    {
        if (!is_null($this->priceFormat)) {
            return $this->priceFormat->formatPrice($this->fee);
        }
        
        return (float) $this->fee;
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
