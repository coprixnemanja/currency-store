<?php
namespace App\Services\CurrencyConversion;

use App\Services\CurrencyConversion\CurrencyConversionInterface;
use App\Models\Currency;

class SimpleCurrencyConversion implements CurrencyConversionInterface
{


    public function calculatePriceInUSD(Currency $currency, int $amount): float
    {
        return round(($amount / $currency->rate) * (1 + ($currency->surcharge / 100)), 4);
    }
}
