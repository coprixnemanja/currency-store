<?php

namespace App\Services\CurrencyConversion;

use App\Models\Currency;
use App\Models\CurrencyOrder;

interface CurrencyConversionInterface{

    public function calculatePriceInUSD(Currency $currency,int $amount): float;
    public function buy(Currency $currency,int $amount): CurrencyOrder|false;
}