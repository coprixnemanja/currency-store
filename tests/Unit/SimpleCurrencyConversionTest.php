<?php

namespace Tests\Unit;

use App\Models\Currency;
use App\Services\CurrencyConversion\SimpleCurrencyConversion;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SimpleCurrencyConversionTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected SimpleCurrencyConversion $instance;

    public function setUp(): void
    {
        parent::setUp();
        $this->setUpFaker();
        $this->instance = new SimpleCurrencyConversion();
    }

    public function test_calculate_price_in_usd()
    {
        $currency = Currency::factory()->create();
        $amounts = [100, 1, 10000];
        foreach ($amounts as $amount) {
            $price = $this->instance->calculatePriceInUSD($currency, $amount);
            $this->assertEquals(round(($amount / $currency->rate) * (1 + ($currency->surcharge / 100)), 4), $price);
        }
    }

    public function test_buy()
    {
        $currency = Currency::factory()->state([
            'discount'=>0,
            'send_order_email'=>0
        ])->create();
        $order = $this->instance->buy($currency,100);
        $this->assertNotFalse($order);
        $this->assertDatabaseHas('currency_orders',$order->toArray());
    }

    public function test_buy_with_discount()
    {
        $amount = 100;
        $discount = 10;
        $currency = Currency::factory()->state([
            'discount'=>$discount,
            'send_order_email'=>0
        ])->create();
        $priceNoDiscount = ($amount / $currency->rate) * (1 + ($currency->surcharge / 100));
        
        $order = $this->instance->buy($currency,$amount);
        $this->assertNotFalse($order);
        $this->assertTrue($order->amount_usd < $priceNoDiscount);
        $this->assertEquals(round($priceNoDiscount - $order->amount_usd,4), round($priceNoDiscount * ($discount / 100),4));
    }
}
