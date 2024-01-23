<?php
namespace App\Services\CurrencyUpdate;


interface CurrencyUpdateInterface{

    public function updateRates():void;
}