<?php

namespace FBNKCMaster\xDBShow\Providers;

use Illuminate\Support\ServiceProvider as Base;
use Illuminate\Support\Facades\Route;

//use Illuminate\Support\Facades\Auth;
//use Illuminate\Contracts\Auth\Guard;

class ServiceProvider extends Base
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        /*
         * Optional methods to load your package assets
         */
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'xDBShow');
        $this->loadViewsFrom(__DIR__.'/../../resources/views', 'xDBShow');
        // $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        //$this->loadRoutesFrom(__DIR__.'/../../routes/web.php');
        $this->registerRoutes();

        if ($this->app->runningInConsole()) {
            // Publishing config.
            // php artisan vendor:publish --provider="FBNKCMaster\xDBShow\Providers\ServiceProvider" --tag="config"
            $this->publishes([
                __DIR__.'/../../config/config.php' => config_path('xDBShow.php'),
            ], 'config');

            // Publishing the views.
            /*$this->publishes([
                __DIR__.'/../resources/views' => resource_path('views/fbnkcmaster/xdbshow'),
            ], 'views');*/

            // Publishing assets.
            $this->publishes([
                __DIR__.'/../../public' => public_path('fbnkcmaster/xdbshow'),
            ], 'xdbshow');

            // Publishing the translation files.
            /*$this->publishes([
                __DIR__.'/../resources/lang' => resource_path('lang/fbnkcmaster/xdbshow'),
            ], 'lang');*/

            // Registering package commands.
            // $this->commands([]);
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__.'/../../config/config.php', 'xdbshow');

        // Register the main class to use with the facade
        /* $this->app->singleton('xDBShow', function () {
            return new xDBShow;
        }); */
    }

    protected function registerRoutes()
    {
        Route::group($this->routeConfiguration(), function () {
            $this->loadRoutesFrom(__DIR__.'/../../routes/web.php');
        });
    }

    protected function routeConfiguration()
    {
        return [
            'prefix' => config('xDBShow.prefix'),
            'middleware' => config('xDBShow.middleware'),
        ];
    }

}