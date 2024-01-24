<?php

namespace Tests\Unit;

use App\Exceptions\DatabaseException;
use App\Models\Currency;
use App\Models\CurrencyOrder;
use App\Services\ClientNotification\ClientNotificationInterface;
use App\Services\CurrencyConversion\SimpleCurrencyConversion;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Mockery;
use Tests\TestCase;

class SimpleCurrencyConversionTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function setUp(): void
    {
        parent::setUp();
        $this->setUpFaker();
    }

    public function test_calculate_price_in_usd()
    {
        $instance = new SimpleCurrencyConversion(Mockery::mock(ClientNotificationInterface::class));
        $currency = Currency::factory()->create();
        $amounts = [100, 1, 10000];
        foreach ($amounts as $amount) {
            $price = $instance->calculatePriceInUSD($currency, $amount);
            $this->assertEquals(round(($amount / $currency->rate) * (1 + ($currency->surcharge / 100)), 4), $price);
        }
    }

    public function test_buy()
    {
        $instance = new SimpleCurrencyConversion(Mockery::mock(ClientNotificationInterface::class));
        $currency = Currency::factory()->state([
            'discount' => 0,
            'send_order_email' => 0
        ])->create();
        $order = $instance->buy($currency, 100);
        $this->assertNotFalse($order);
        $this->assertDatabaseHas('currency_orders', $order->toArray());
    }
    public function test_buy_throws_exception()
    {
        $instance = new SimpleCurrencyConversion(Mockery::mock(ClientNotificationInterface::class));
        $currency = Currency::factory()->state([
            'discount' => 0,
            'send_order_email' => 0
        ])->create();
        CurrencyOrder::saving(
            function () {
                throw new \PDOException();
            }
        );
        $this->expectException(DatabaseException::class);
        $instance->buy($currency, 100);
    }

    public function test_buy_with_discount()
    {
        $instance = new SimpleCurrencyConversion(Mockery::mock(ClientNotificationInterface::class));
        $amount = 100;
        $discount = 10;
        $currency = Currency::factory()->state([
            'discount' => $discount,
            'send_order_email' => 0
        ])->create();
        $priceNoDiscount = ($amount / $currency->rate) * (1 + ($currency->surcharge / 100));

        $order = $instance->buy($currency, $amount);
        $this->assertNotFalse($order);
        $this->assertTrue($order->amount_usd < $priceNoDiscount);
        $this->assertEquals(round($priceNoDiscount - $order->amount_usd, 2), round($priceNoDiscount * ($discount / 100), 2));
    }

    public function test_buy_with_email_send()
    {
        $mock = Mockery::mock(ClientNotificationInterface::class);
        $instance = new SimpleCurrencyConversion($mock);
        $amount = 100;
        $currency = Currency::factory()->state([
            'send_order_email' => 1
        ])->create();
        $mock->shouldReceive('sendSuccessfulOrder')->with(Mockery::on(function (CurrencyOrder $order) {
            return true;
        }))->times(1);
        $instance->buy($currency, $amount);
    }
}
