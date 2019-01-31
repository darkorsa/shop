<?php declare(strict_types=1);

/*
 * This file is part of the Plane\Shop package.
 *
 * (c) Dariusz Korsak <dkorsak@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Plane\Shop;

use Money\Money;
use Money\MoneyFormatter;
use Plane\Shop\CartInterface;
use Plane\Shop\CartItemInterface;
use Plane\Shop\CartCommonDecorator;
use Money\Currencies\ISOCurrencies;
use Money\Formatter\DecimalMoneyFormatter;

class CartPresentator implements CartPresentatorInterface
{
    use CartCommonDecorator;
    
    private $cart;

    private $priceFormatter;

    public function __construct(CartInterface $cart, MoneyFormatter $priceFormatter = null)
    {
        $this->cart = $cart;
        $this->priceFormatter = $priceFormatter ?: new DecimalMoneyFormatter(new ISOCurrencies());
    }

    public function totalNet(): string
    {
        return $this->priceFormatter->format($this->cart->totalNet());
    }

    public function totalGross(): string
    {
        return $this->priceFormatter->format($this->cart->totalGross());
    }
    
    public function tax(): string
    {
        return $this->priceFormatter->format($this->cart->tax());
    }
    
    public function totalAfterDiscounts(): string
    {
        return $this->priceFormatter->format($this->cart->totalAfterDiscounts());
    }
    
    public function shippingCost(): string
    {
        return $this->priceFormatter->format($this->cart->shippingCost());
    }
    
    public function paymentFee(): string
    {
        return $this->priceFormatter->format($this->cart->paymentFee());
    }

    public function toArray(): array
    {
        $array = [];
        $array['items'] = array_map(function (CartItemInterface $item) {
            $itemArray = $item->toArray($this->getCurrency());

            array_walk_recursive($itemArray, function (&$value, $key) {
                if ($value instanceof Money) {
                    $value = $this->priceFormatter->format($value);
                }
            });

            return $itemArray;
        }, $this->items());
        
        if (!is_null($this->getShipping())) {
            $array['shipping']['name']      = $this->getShipping()->getName();
            $array['shipping']['desc']      = $this->getShipping()->getDescription();
            $array['shipping']['cost']      = $this->shippingCost();
        }
        
        if (!is_null($this->getPayment())) {
            $array['payment']['name']       = $this->getPayment()->getName();
            $array['payment']['desc']       = $this->getPayment()->getDescription();
            $array['payment']['fee']        = $this->paymentFee();
        }
        
        $array['discounts'] = array_map(function (CartDiscount $discount) {
            return [
                'text'  => $discount->getDiscountText(),
                'price' => $this->priceFormatter->format($discount->getPriceAfterDiscount())
            ];
        }, $this->getDiscounts());
        
        $array['itemsQuantity']         = $this->itemsQuantity();
        $array['totalNet']              = $this->totalNet();
        $array['totalGross']            = $this->totalGross();
        $array['tax']                   = $this->tax();
        $array['totalWeight']           = $this->weight();
        $array['shippingCost']          = $this->shippingCost();
        $array['paymentFee']            = $this->paymentFee();
        $array['totalAfterDiscounts']   = $this->totalAfterDiscounts();
        
        return $array;
    }
}
