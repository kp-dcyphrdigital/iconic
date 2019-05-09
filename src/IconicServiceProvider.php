<?php

namespace SYG\Iconic;

use Illuminate\Support\ServiceProvider;

class IconicServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'iconic');

        $this->app->bind('SYG\Iconic\ApiClient', function ($app) {
            $httpClient = new \GuzzleHttp\Client([ 
                'headers' => ['Content-type' => 'text/xml', 'Accept' => 'Version_2.0'],
            ]);
            $globalParameters = [
                'UserID' => config('iconic.apiUser'),
                'Version' => '1.0',
                'Timestamp' => now()->format('c'),
                'Format' => 'JSON',
            ];
            return new \SYG\Iconic\ApiClient($httpClient, $globalParameters);
        });
        
        $this->app->bind('SYG\Iconic\OrderRetriever', function($app) {
            return new \SYG\Iconic\OrderRetriever(app('SYG\Iconic\ApiClient'));
        });

        $this->app->bind('SYG\Iconic\OrderItemUpdater', function($app) {
            return new \SYG\Iconic\OrderItemUpdater(app('SYG\Iconic\ApiClient'));
        });

        $this->app->bind('SYG\Iconic\ProductsUpdater', function($app) {
            return new \SYG\Iconic\ProductsUpdater(app('SYG\Iconic\ApiClient'));
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'iconic');

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/config.php' => config_path('iconic.php'),
            ], 'config');
            $this->commands([
                //
            ]);
        }
    }
}
