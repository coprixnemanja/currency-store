<?php

namespace Tests\Unit;

use App\Mail\CurrencyOrderSuccess;
use App\Models\CurrencyOrder;
use App\Services\ClientNotification\StaticEmailNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Mail\PendingMail;
use Mockery;
use Tests\TestCase;
use Illuminate\Support\Facades\Mail;

class StaticEmailNotificationTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    public function test_send_successful_order(): void
    {
        $order = CurrencyOrder::factory()->create();
        $staticEmail = $this->faker->email;
        $instance = new StaticEmailNotification($staticEmail);
        $pendingMail = Mockery::mock(PendingMail::class);
        Mail::shouldReceive('to')->withArgs([$staticEmail])->times(1)->andReturn($pendingMail);
        $pendingMail->shouldReceive('send')->with(Mockery::on(
            function (CurrencyOrderSuccess $mailable) {
                return true;
            }
        ))->times(1);
        $instance->sendSuccessfulOrder($order);
    }
}
