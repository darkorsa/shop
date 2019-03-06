<?php declare(strict_types=1);

/*
 * This file is part of the Plane\Shop package.
 *
 * (c) Dariusz Korsak <dkorsak@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Plane\Shop\Discount;

use Money\Money;
use Money\Currency;
use Plane\Shop\CartInterface;
use Plane\Shop\DiscountAbstract;
use Plane\Shop\Traits\CartCommon;
use Plane\Shop\Traits\CartPrices;
use Money\Currencies\ISOCurrencies;
use Money\Parser\DecimalMoneyParser;

class TotalPriceThresholdDiscount extends DiscountAbstract implements CartInterface
{
    use CartCommon;
    use CartPrices;
    
    protected $treshold;
    
    protected $discount;

    protected function applyDiscount(): void
    {
        $total = $this->totalAfterDiscounts();

        if ($total->greaterThanOrEqual($this->getTreshold($this->getCurrency()))) {
            $total = $total->subtract($total->multiply($this->discount));
        }

        $this->cartDiscount->setPriceAfterDiscount($total);
        
        $this->addDiscount($this->cartDiscount);
    }

    private function getTreshold(string $currency): Money
    {
        $moneyParser = new DecimalMoneyParser(new ISOCurrencies());
        
        return $moneyParser->parse((string) $this->treshold, new Currency($currency));
    }
}
