<?php

namespace Tests\Unit;

use App\Exceptions\CurrencyLayerHttp;
use App\Models\Currency;
use App\Services\CurrencyUpdate\CurrencyLayerUpdater;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\Response;
use Tests\TestCase;
use Mockery;
use ReflectionClass;

class CurrencyLayerUpdaterTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected CurrencyLayerUpdater $instance;
    protected string $apiKey;
    protected string $url;

    public function setUp(): void
    {
        parent::setUp();
        $this->setUpFaker();
        $this->apiKey = 'test123';
        $this->url = $this->faker->url(32);
        $this->instance = new CurrencyLayerUpdater($this->apiKey, $this->url);
    }

    public function test_update_chunk(): void
    {
        $currencies = Currency::factory()->count(3)->create();
        $class = new ReflectionClass(CurrencyLayerUpdater::class);
        $method = $class->getMethod('updateBatch');
        $response = Mockery::mock(Response::class);
        Http::shouldReceive('get')->once()->with(
            $this->url,
            [
                'currencies' => implode(',', $currencies->pluck('signature')->toArray()),
                'source' => 'USD',
                'format' => 1,
                'access_key' => $this->apiKey
            ]
        )->andReturn($response);
        $response->shouldReceive('ok')->andReturn(true);
        $updateData = [];
        foreach ($currencies as $currency) {
            $updateData["USD" . $currency->signature] = $this->faker->randomFloat(8, 0, 10);
        }
        $response->shouldReceive('json')->andReturn([
            "quotes" => $updateData
        ]);
        $method->invokeArgs($this->instance, [$currencies]);
        foreach ($currencies as $currency) {
            $this->assertDatabaseHas('currencies', ['signature' => $currency->signature, 'rate' => $updateData['USD' . $currency->signature]]);
        }
    }

    public function test_update_chunk_request_nok(): void
    {
        $currencies = Currency::factory()->count(3)->create();
        $class = new ReflectionClass(CurrencyLayerUpdater::class);
        $method = $class->getMethod('updateBatch');
        $response = Mockery::mock(Response::class);
        Http::shouldReceive('get')->once()->with(
            $this->url,
            [
                'currencies' => implode(',', $currencies->pluck('signature')->toArray()),
                'source' => 'USD',
                'format' => 1,
                'access_key' => $this->apiKey
            ]
        )->andReturn($response);
        $response->shouldReceive('ok')->andReturn(false);
        $this->expectException(CurrencyLayerHttp::class);
        $method->invokeArgs($this->instance, [$currencies]);
    }

    public function test_update_wrong_pair_returned(): void
    {
        $currencies = Currency::factory()->count(3)->create();
        $class = new ReflectionClass(CurrencyLayerUpdater::class);
        $method = $class->getMethod('updateBatch');
        $response = Mockery::mock(Response::class);
        Http::shouldReceive('get')->once()->with(
            $this->url,
            [
                'currencies' => implode(',', $currencies->pluck('signature')->toArray()),
                'source' => 'USD',
                'format' => 1,
                'access_key' => $this->apiKey
            ]
        )->andReturn($response);
        $response->shouldReceive('ok')->andReturn(true);
        foreach ($currencies as $currency) {
            $updateData["USDNON"] = $this->faker->randomFloat(8, 0, 10);
        }
        $response->shouldReceive('json')->andReturn([
            "quotes" => $updateData
        ]);
        $this->expectException(CurrencyLayerHttp::class);
        $method->invokeArgs($this->instance, [$currencies]);
    }

    public function test_update_all_currencies(): void
    {
        $currencies = Currency::factory()->count(12)->create();
        $mock = Mockery::mock(CurrencyLayerUpdater::class)->makePartial()->shouldAllowMockingProtectedMethods();
        $idsProcessed = [];
        $mock->shouldReceive('updateBatch')->with(Mockery::on(function($collection) use(&$idsProcessed){
            foreach ($collection as $m) {
                $idsProcessed[] = $m->id;
            }
            return true;
        }))->times(3)->andReturn(true);
        $mock->updateRates();
        foreach($currencies as $c){
            $this->assertTrue(in_array($c->id,$idsProcessed));
        }
    }

    public function test_update_all_no_currencies(): void
    {
        $mock = Mockery::mock(CurrencyLayerUpdater::class)->makePartial()->shouldAllowMockingProtectedMethods();
        $mock->shouldReceive('updateBatch')->times(0)->andReturn(true);
        $mock->updateRates();
    }
}
