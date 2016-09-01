<?php

namespace Plane\Shop;

/**
 * Description of Shipping
 *
 * @author Dariusz Korsak <dkorsak@gmail.com>
 * @package Plane/Shop
 */
class Shipping implements ShippingInterface
{
    protected $id;
    
    protected $name;
    
    protected $description;
    
    protected $cost;
    
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
    
    public function getDescription()
    {
        return $this->description;
    }
    
    public function getCost()
    {
        return $this->cost;
    }
}
