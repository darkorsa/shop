<?php

namespace Plane\Shop;

use Plane\Shop\PriceFormat\PriceFormatInterface;

/**
 * Interface for payment classes
 * @author Dariusz Korsak <dkorsak@gmail.com>
 */
interface PaymentInterface
{
    public function getId();
   
    public function getName();

    public function getDescription();
    
    public function getFee();
    
    public function setPriceFormat(PriceFormatInterface $priceFormat);
}
