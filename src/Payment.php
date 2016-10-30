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
     * Fee is a fixed price
     */
    const FEE_FIXED = 'fixed';
    
    /**
     * Fee is calculated as a percentage of total price
     */
    const FEE_PERCENTAGE = 'percentage';
    
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
     * Payment fee type (fee_fixed|fee_percentage)
     * @var type
     */
    private $feeType = self::FEE_FIXED;
    
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
     * Set fee as fixed price
     */
    public function setFixed()
    {
        $this->feeType = self::FEE_FIXED;
    }
    
    /**
     * Set fee as percentage of total price
     */
    public function setPercentage()
    {
        $this->feeType = self::FEE_PERCENTAGE;
    }
    
    /**
     * Return fee
     * @param float $totalPrice
     * @return float
     */
    public function getFee($totalPrice)
    {
        if (!is_null($this->priceFormat)) {
            return $this->priceFormat->formatPrice($this->calculateFee($totalPrice));
        }
        
        return $this->calculateFee($totalPrice);
    }
    
    /**
     * Set price format object
     * @param \Plane\Shop\PriceFormat\PriceFormatInterface $priceFormat
     */
    public function setPriceFormat(PriceFormatInterface $priceFormat)
    {
        $this->priceFormat = $priceFormat;
    }
    
    /**
     * Calculate fee based on feeType
     * @param type $totalPrice
     * @return float
     */
    protected function calculateFee($totalPrice)
    {
        if ($this->feeType == self::FEE_PERCENTAGE) {
            return (float) $totalPrice * $this->fee;
        }
        
        return (float) $this->fee;
    }
}
