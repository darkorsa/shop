<?php

namespace Plane\Shop;

use DomainException;

use Plane\Shop\QuantityValidatorInterface;
use Plane\Shop\PriceFormat\PriceFormatInterface;

/**
 * Description of CartItem
 *
 * @author Dariusz Korsak <dkorsak@gmail.com>
 * @package Plane\Shop
 */
class CartItem implements CartItemInterface
{
    protected $product;
    
    protected $quantityValidator;
    
    protected $quantity;
    
    protected $priceFormat;
    
    /**
     * Constructor
     * @param Plane\Shop\ProductInterface $product
     * @param integer $quantity
     * @param Plane\Shop\QuantityValidatorInterface $quantityValidator
     * @throws DomainException
     */
    public function __construct(ProductInterface $product, $quantity = 1, QuantityValidatorInterface $quantityValidator = null)
    {
        $this->product = $product;
        $this->quantityValidator = $quantityValidator;
        
        if (!$this->validateQuantity($quantity)) {
            throw new DomainException(sprintf('Quantity of %d is invalid for product %d', $quantity, $product->getId()));
        }
        
        $this->quantity = (int) $quantity;
    }

    public function getId()
    {
        return $this->product->getId();
    }
        
    public function getName()
    {
        return $this->product->getName();
    }
    
    public function getImagePath()
    {
        return $this->product->getImagePath();
    }
    
    public function getQuantity()
    {
        return $this->quantity;
    }
    
    public function setQuantity($quantity)
    {
        if (!$this->validateQuantity($quantity)) {
            throw new DomainException('Quantity of' . $quantity . ' is invalid');
        }
        
        $this->quantity = (int) $quantity;
    }
    
    public function increaseQuantity($quantity)
    {
        $newQuantity = $this->quantity + (int) $quantity;
        
        $this->setQuantity($newQuantity);
    }
    
    public function decreaseQuantity($quantity)
    {
        $newQuantity = $this->quantity - (int) $quantity;
        
        $this->setQuantity($newQuantity);
    }
    
    public function getTax()
    {
        return $this->formatPrice((float) $this->product->getPrice() * $this->product->getTaxRate());
    }
            
    public function getTaxTotal()
    {
        return $this->formatPrice((float) $this->getTax() * $this->quantity);
    }
    
    public function getPrice()
    {
        return $this->formatPrice((float) $this->product->getPrice());
    }
    
    public function getPriceTotal()
    {
        return $this->formatPrice((float) $this->getPrice() * $this->quantity);
    }
    
    public function getPriceWithTax()
    {
        return $this->formatPrice((float) $this->getPrice() + $this->getTax());
    }
    
    public function getPriceTotalWithTax()
    {
        return $this->formatPrice((float) $this->getPriceTotal() + $this->getTaxTotal());
    }
    
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
        $array['tax']               = $this->getTax();
        $array['totalTax']          = $this->getTaxTotal();
        $array['price']             = $this->getPrice();
        $array['priceWithTax']      = $this->getPriceWithTax();
        $array['priceTotal']        = $this->getPriceTotal();
        $array['priceTotalWithTax'] = $this->getPriceTotalWithTax();
        
        return $array;
    }
    
    protected function validateQuantity($quantity)
    {
        if (is_null($this->quantityValidator)) {
            return true;
        }
        
        return $this->quantityValidator->validate($this->product, $quantity);
    }
    
    protected function formatPrice($price)
    {
        if (is_null($this->priceFormat)) {
            return $price;
        }
        
        return $this->priceFormat->formatPrice($price);
    }
}
