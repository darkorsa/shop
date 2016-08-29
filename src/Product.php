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
    protected $id;
    
    protected $name;
    
    protected $price;
    
    protected $imagePath;
    
    protected $taxRate;
    
    public function __construct(array $data)
    {
        foreach ($data as $k => $v) {
            $this->$k = $v;
        }
    }
    
    public function getId()
    {
        return $this->id;
    }
    
    public function getName()
    {
        return $this->name;
    }
    
    public function getPrice()
    {
        return $this->price;
    }
    
    public function getTaxRate()
    {
        return $this->taxRate;
    }
    
    public function getImagePath()
    {
        if (file_exists($this->imagePath)) {
            return $this->imagePath;
        }
        
        return null;
    }
}
