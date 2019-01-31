<?php declare(strict_types=1);

namespace Plane\Shop;

interface CartPresentatorInterface extends CartCommonInterface
{
    public function totalNet(): string;
    
    public function totalGross(): string;
    
    public function tax(): string;
    
    public function totalAfterDiscounts(): string;
    
    public function shippingCost(): string;
    
    public function paymentFee(): string;

    public function toArray(): array;
}
