<?php

namespace Tests\Feature\Currency;

use App\Models\Currency;
use App\Models\CurrencyOrder;
use App\Services\CurrencyConversion\CurrencyConversionInterface;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use Tests\CreatesApplication;
use Tests\TestCase;

class BaseTest extends TestCase
{
    use RefreshDatabase, CreatesApplication;

    protected function setUp(): void
    {
        parent::setUp();
        $mock = Mockery::mock(CurrencyConversionInterface::class);
        $mock->shouldReceive('calculatePriceInUSD')->andReturn('1.1');
        $mock->shouldReceive('buy')->andReturn(CurrencyOrder::factory()->create());
        app()->bind(CurrencyConversionInterface::class,function($app) use ($mock){
            return $mock;
        });
    }

    public function test_endpoint_calculate_price_status_400_on_bad_request(): void
    {
        $id = Currency::factory()->create()->id;
        $response = $this->get("api/currencies/$id/calculate-price?amount=-1");
        $response->assertStatus(400);
        $response->assertViewIs('components.info.error');
    }
    public function test_endpoint_calculate_price_status_404_on_currency_not_found(): void
    {
        $response = $this->getJson("api/currencies/1/calculate-price?amount=100");
        $response->assertStatus(404);
        $response->assertViewIs('components.info.error');
    }
    public function test_endpoint_calculate_price_returns_float(): void
    {
        $id = Currency::factory()->create()->id;
        $response = $this->get("api/currencies/$id/calculate-price?amount=100");
        $response->assertStatus(200);
        $this->assertTrue(is_numeric($response->baseResponse->getContent()));
    }

    public function test_endpoint_buy_status_400_on_bad_request(): void
    {
        $id = Currency::factory()->create()->id;
        $response = $this->post("api/currencies/$id/buy?amount=-1");
        $response->assertStatus(400);
        $response->assertViewIs('components.info.error');
    }
    public function test_endpoint_buy_status_404_on_currency_not_found(): void
    {
        $response = $this->post("api/currencies/1/buy?amount=100");
        $response->assertStatus(404);
        $response->assertViewIs('components.info.error');
    }
    public function test_endpoint_buy_returns_right_view(): void
    {
        $id = Currency::factory()->create()->id;
        $response = $this->post("api/currencies/$id/buy?amount=100");
        $response->assertStatus(200);
        $response->assertViewIs('components.currency-order');
    }

    public function test_endpoint_show_status_404_on_currency_not_found(): void
    {
        $response = $this->get("api/currencies/1");
        $response->assertStatus(404);
        $response->assertViewIs('components.info.error');
    }
    public function test_endpoint_show_returns_right_view(): void
    {
        $id = Currency::factory()->create()->id;
        $response = $this->post("api/currencies/$id/buy?amount=100");
        $response->assertStatus(200);
        $response->assertViewIs('components.currency-order');
    }
}
