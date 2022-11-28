<?php

declare(strict_types=1);

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
use Money\Currencies\ISOCurrencies;
use Money\Parser\DecimalMoneyParser;
use Plane\Shop\CartDiscountAbstract;

class TotalPriceThresholdDiscount extends CartDiscountAbstract
{
    protected $treshold;

    protected $discount;

    protected function applyDiscount(): void
    {
        $this->priceAfterDiscount = $this->price;

        if ($this->price->greaterThanOrEqual($this->getTreshold($this->currency))) {
            $this->priceAfterDiscount = $this->price->subtract($this->price->multiply((string) $this->discount));
        }
    }

    private function getTreshold(string $currency): Money
    {
        $moneyParser = new DecimalMoneyParser(new ISOCurrencies());

        return $moneyParser->parse((string) $this->treshold, new Currency($currency));
    }
}
