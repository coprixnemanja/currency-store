<?php

namespace App\Providers;

use App\Services\CurrencyConversion\CurrencyConversionInterface;
use Illuminate\Support\ServiceProvider;
use App\Services\CurrencyConversion\SimpleCurrencyConversion;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(CurrencyConversionInterface::class,SimpleCurrencyConversion::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
