<?php

namespace App\Services\CurrencyConversion;

use App\Models\Currency;

interface CurrencyConversionInterface{

    public function calculatePriceInUSD(Currency $currency,int $amount): float;
}