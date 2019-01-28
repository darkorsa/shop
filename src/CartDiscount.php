<?php

namespace Plane\Shop;

use Plane\Shop\PriceFormat\PriceFormatInterface;

/**
 * Discount class that can be applied to Cart
 *
 * @author Dariusz Korsak <dkorsak@gmail.com>
 * @package Plane\Shop
 */
class CartDiscount
{
    /**
     * Discount text
     * @var string
     */
    private $discountText;
    
    /**
     * Price after discount
     * @var int|float
     */
    private $priceAfterDiscount;
    
    /**
     * Price format object
     * @var \Plane\Shop\PriceFormat\PriceFormatInterface
     */
    private $priceFormat;
    
    /**
     * Set discount text
     * @param string $discountText
     */
    public function setDiscountText($discountText)
    {
        $this->discountText = $discountText;
    }
    
    /**
     * Set price after discount
     * @param double $priceAfterDiscount
     */
    public function setPriceAfterDiscount($priceAfterDiscount)
    {
        $this->priceAfterDiscount = $priceAfterDiscount;
    }
    
    /**
     * Return discount text
     * @return string
     */
    public function getDiscountText()
    {
        return $this->discountText;
    }
    
    /**
     * Return price after discount
     * @return int|float
     */
    public function getPriceAfterDiscount()
    {
        return $this->formatPrice($this->priceAfterDiscount);
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
     * Format price with set price format object
     * @param float $price
     * @return float
     */
    protected function formatPrice($price)
    {
        if (is_null($this->priceFormat)) {
            return $price;
        }
        
        return $this->priceFormat->formatPrice($price);
    }
}
