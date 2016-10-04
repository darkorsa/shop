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
     * @return float|int
     */
    public function getFee();
    
    /**
     * Set price format object
     * @param \Plane\Shop\PriceFormat\PriceFormatInterface $priceFormat
     */
    public function setPriceFormat(PriceFormatInterface $priceFormat);
}
