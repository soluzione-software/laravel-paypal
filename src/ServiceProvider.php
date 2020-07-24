<?php

namespace SoluzioneSoftware\Laravel\PayPal;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerClient();
        $this->registerConfig();
    }

    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        $this->bootRoutes();
    }

    private function registerClient()
    {
        $this->app->singleton('paypal.client', function () {
            return new Client();
        });
    }

    private function registerConfig()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/paypal.php', 'paypal'
        );
    }

    private function bootRoutes()
    {
        Route::group($this->routesConfiguration(), function () {
            $this->loadRoutesFrom(__DIR__.'/../routes/api.php');
        });
    }

    /**
     * Get the routes group configuration array.
     *
     * @return array
     */
    private function routesConfiguration()
    {
        return [
            'namespace' => 'SoluzioneSoftware\Laravel\PayPal\Http\Controllers',
            'as' => 'paypal.api.',
            'prefix' => Config::get('paypal.routes_prefix'),
        ];
    }
}
