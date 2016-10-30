<?php

namespace Plane\Shop;

use Plane\Shop\PriceFormat\PriceFormatInterface;

/**
 * Interface for payment classes
 * @author Dariusz Korsak <dkorsak@gmail.com>
 */
interface PaymentInterface
{
    /**
     * Return id
     * @return int
     */
    public function getId();
   
    /**
     * Return name
     * @return string
     */
    public function getName();

    /**
     * Return description
     * @return string
     */
    public function getDescription();
    
    /**
     * Return fee
     * @param float $totalPrice
     * @return float
     */
    public function getFee($totalPrice);
    
    /**
     * Set fee as fixed price
     */
    public function setFixed();
    
    /**
     * Set fee as percentage of total price
     */
    public function setPercentage();

    /**
     * Set price format object
     * @param \Plane\Shop\PriceFormat\PriceFormatInterface $priceFormat
     */
    public function setPriceFormat(PriceFormatInterface $priceFormat);
}
