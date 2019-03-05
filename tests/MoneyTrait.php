<?php

namespace Plane\Shop\Tests;

use Money\Money;
use Money\Currency;
use Money\Currencies\ISOCurrencies;
use Money\Parser\DecimalMoneyParser;
use Money\Formatter\DecimalMoneyFormatter;

trait MoneyTrait
{
    protected function getMoney($amount)
    {
        $moneyParser = new DecimalMoneyParser(new ISOCurrencies());
        
        return $moneyParser->parse((string) $amount, new Currency(self::CURRENCY));
    }

    protected function getAmount(Money $money)
    {
        $priceFormatter = new DecimalMoneyFormatter(new ISOCurrencies());

        return $priceFormatter->format($money);
    }
}