<?php

namespace App\Providers;

use App\Services\ClientNotification\ClientNotificationInterface;
use App\Services\ClientNotification\StaticEmailNotification;
use App\Services\CurrencyConversion\CurrencyConversionInterface;
use Illuminate\Support\ServiceProvider;
use App\Services\CurrencyConversion\SimpleCurrencyConversion;
use App\Services\CurrencyUpdate\CurrencyLayerUpdater;
use App\Services\CurrencyUpdate\CurrencyUpdateInterface;
use Illuminate\Contracts\Foundation\Application;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(ClientNotificationInterface::class,function(Application $app){
            return new StaticEmailNotification(config('mail.static_email'));
        });
        $this->app->bind(CurrencyConversionInterface::class,function(Application $app){
            return new SimpleCurrencyConversion($app->make(ClientNotificationInterface::class));
        });
        $this->app->bind(CurrencyUpdateInterface::class,function(Application $app){
            return new CurrencyLayerUpdater(config('currencylayer.api_key'),config('currencylayer.api_url'));
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
