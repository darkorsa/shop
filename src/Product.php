<?php

namespace Plane\Shop;

/**
 * Shop product class
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
     * Set price
     * @param int|float $price
     */
    public function setPrice($price)
    {
        $this->price = $price;
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
}
