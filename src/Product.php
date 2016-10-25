<?php

namespace Plane\Shop;

use Plane\Shop\PriceFormat\PriceFormatInterface;

/**
 * Abstraction layer for product
 *
 * @author Dariusz Korsak <dkorsak@gmail.com>
 * @package Plane\Shop
 */
class Product implements ProductInterface
{
    /**
     * Product id
     * @var int
     */
    protected $id;
    
    /**
     * Product name
     * @var string
     */
    protected $name;
    
    /**
     * Product price
     * @var int|float
     */
    protected $price;
    
    /**
     * Product weight
     * @var int|foat
     */
    protected $weight;
    
    /**
     * Product quantity
     * @var int
     */
    protected $quantity;
    
    /**
     * Product path to image
     * @var string
     */
    protected $imagePath;
    
    /**
     * Product tax rate
     * @var float
     */
    protected $taxRate;
    
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
     * @return ing
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
     * Return price
     * @return float
     */
    public function getPrice()
    {
        return (float) $this->price;
    }
    
    /**
     * Return weight
     * @return float
     */
    public function getWeight()
    {
        return (float) $this->weight;
    }
    
    /**
     * Set price
     * @param int|float $price
     */
    public function setPrice($price)
    {
        $this->price = $price;
    }
    
    /**
     * Return quantity
     * @return int
     */
    public function getQuantity()
    {
        return (int) $this->quantity;
    }
    
    /**
     * Return image path
     * @return string|null
     */
    public function getImagePath()
    {
        if (file_exists($this->imagePath)) {
            return $this->imagePath;
        }
        
        return null;
    }
    
    /**
     * Return tax rate
     * @return float
     */
    public function getTaxRate()
    {
        return (float) $this->taxRate;
    }
    
    /**
     * Return tax for single item
     * @return float
     */
    public function getTax()
    {
        return $this->formatPrice((float) $this->getPrice() * $this->getTaxRate());
    }
    
    /**
     * Return price including tax for single item
     * @return float
     */
    public function getPriceWithTax()
    {
        return $this->formatPrice((float) $this->getPrice() + $this->getTax());
    }
    
    /**
     * Set price format object
     * @param \Plane\Shop\PriceFormat\PriceFormatInterface $priceFormat
     */
    public function setPriceFormat(PriceFormatInterface $priceFormat)
    {
        $this->priceFormat = $priceFormat;
    }
    
    public function toArray()
    {
        $array = [];
        $array['id']                = $this->getId();
        $array['name']              = $this->getName();
        $array['imagePath']         = $this->getImagePath();
        $array['quantity']          = $this->getQuantity();
        $array['taxRate']           = $this->getTaxRate();
        $array['tax']               = $this->getTax();
        $array['price']             = $this->getPrice();
        $array['weight']            = $this->getWeight();
        $array['priceWithTax']      = $this->getPriceWithTax();

        return $array;
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
