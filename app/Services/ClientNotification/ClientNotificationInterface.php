<?php
namespace App\Services\ClientNotification;

use App\Models\CurrencyOrder;

interface ClientNotificationInterface{

    public function sendSuccessfulOrder(CurrencyOrder $order):void;
}