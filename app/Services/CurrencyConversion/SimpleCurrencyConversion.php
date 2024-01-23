<?php

namespace App\Services\CurrencyConversion;

use App\Services\CurrencyConversion\CurrencyConversionInterface;
use App\Models\Currency;
use App\Models\CurrencyOrder;
use App\Services\ClientNotification\ClientNotificationInterface;

class SimpleCurrencyConversion implements CurrencyConversionInterface
{
    public function __construct(public ClientNotificationInterface $notificationService) {
    }


    public function calculatePriceInUSD(Currency $currency, int $amount): float
    {
        $price = $this->calcPriceBeforeSur($currency->rate, $amount);
        $surcharge = $this->calcSurchargeAmount($price, $currency->surcharge);
        return round($price + $surcharge, 4);
    }

    public function buy(Currency $currency, int $amount): CurrencyOrder|false
    {
        $price = $this->calcPriceBeforeSur($currency->rate, $amount);
        $surcharge = $this->calcSurchargeAmount($price, $currency->surcharge);
        $discount = $this->calcDiscount($price + $surcharge, $currency->discount);
        $model = new CurrencyOrder([
            'currency_id' => $currency->id,
            'rate' => $currency->rate,
            'surcharge_percentage' => $currency->surcharge,
            'surcharge_amount' => round($surcharge,4),
            'amount_purchased' => $amount,
            'amount_usd' => round($price + $surcharge - $discount,4),
            'discount_percentage' => $currency->discount,
            'discount_amount' => round($discount,4)
        ]);
        if (!$model->save()) {
            return false;
        }
        if($currency->send_order_email){
            $this->notificationService->sendSuccessfulOrder($model);
        }
        return $model;
    }
    protected function calcPriceBeforeSur(float $rate, int $amount)
    {
        return $amount / $rate;
    }
    protected function calcDiscount(float $price, float $discount)
    {
        return $price * ($discount / 100);
    }
    protected function calcSurchargeAmount(float $priceBeforeSur, float $surcharge): float
    {
        return $priceBeforeSur * ($surcharge / 100);
    }
}
