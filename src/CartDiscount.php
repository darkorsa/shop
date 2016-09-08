<?php

namespace Plane\Shop;

use Plane\Shop\PriceFormat\PriceFormatInterface;

/**
 * Description of CartDiscount
 *
 * @author Dariusz Korsak <dkorsak@gmail.com>
 * @package Plane\Shop
 */
class CartDiscount
{
    private $discountText;
    
    private $priceAfterDiscount;
    
    public function setDiscountTest($discountText)
    {
        $this->discountText = $discountText;
    }
    
    public function setPriceAfterDiscount($priceAfterDiscount)
    {
        $this->priceAfterDiscount = $priceAfterDiscount;
    }
    
    public function getDiscountText()
    {
        return $this->discountText;
    }
    
    public function getPriceAfterDiscount()
    {
        return $this->priceFormat->formatPrice($this->priceAfterDiscount);
    }
    
    public function setPriceFormat(PriceFormatInterface $priceFormat)
    {
        $this->priceFormat = $priceFormat;
    }
}
