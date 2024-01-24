<?php

namespace App\Services\ClientNotification;

use App\Mail\CurrencyOrderSuccess;
use App\Models\CurrencyOrder;
use Illuminate\Support\Facades\Mail;

class StaticEmailNotification implements ClientNotificationInterface
{

    public function __construct(protected string $staticEmail)
    {
    }

    public function sendSuccessfulOrder(CurrencyOrder $order): void
    {
        Mail::to($this->staticEmail)->send(new CurrencyOrderSuccess($order));
    }
}
