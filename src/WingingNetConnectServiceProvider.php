<?php

namespace WingingIt\WingingNetConnect;

use Illuminate\Support\ServiceProvider;

class WingingNetConnectServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'WingingIt');
        $this->loadViewsFrom(__DIR__.'/resources/views', 'WingingIt');
        // $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        // $this->loadRoutesFrom(__DIR__.'/routes.php');

        // Publishing is only necessary when using the CLI.
        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
        }
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/wingingnetconnect.php', 'wingingnetconnect');

        // Register the service the package provides.
        $this->app->singleton('wingingnetconnect', function ($app) {
            return new WingingNetConnect;
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['wingingnetconnect'];
    }
    
    /**
     * Console-specific booting.
     *
     * @return void
     */
    protected function bootForConsole()
    {
        // Publishing the configuration file.
        $this->publishes([
            __DIR__.'/../config/wingingnetconnect.php' => config_path('wingingnetconnect.php'),
        ], 'wingingnetconnect.config');

        // Publishing the views.
        /*$this->publishes([
            __DIR__.'/../resources/views' => base_path('resources/views/vendor/WingingIt'),
        ], 'wingingnetconnect.views');*/

        // Publishing assets.
        /*$this->publishes([
            __DIR__.'/../resources/assets' => public_path('vendor/WingingIt'),
        ], 'wingingnetconnect.views');*/

        // Publishing the translation files.
        /*$this->publishes([
            __DIR__.'/../resources/lang' => resource_path('lang/vendor/WingingIt'),
        ], 'wingingnetconnect.views');*/

        // Registering package commands.
        // $this->commands([]);
    }
}
