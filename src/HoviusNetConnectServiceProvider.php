<?php

namespace Wshovius\HoviusNetConnect;

use Illuminate\Support\ServiceProvider;

class HoviusNetConnectServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'wshovius');
        // $this->loadViewsFrom(__DIR__.'/../resources/views', 'wshovius');
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
        $this->mergeConfigFrom(__DIR__.'/../config/hoviusnetconnect.php', 'hoviusnetconnect');

        // Register the service the package provides.
        $this->app->singleton('hoviusnetconnect', function ($app) {
            return new HoviusNetConnect;
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['hoviusnetconnect'];
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
            __DIR__.'/../config/hoviusnetconnect.php' => config_path('hoviusnetconnect.php'),
        ], 'hoviusnetconnect.config');

        // Publishing the views.
        /*$this->publishes([
            __DIR__.'/../resources/views' => base_path('resources/views/vendor/wshovius'),
        ], 'hoviusnetconnect.views');*/

        // Publishing assets.
        /*$this->publishes([
            __DIR__.'/../resources/assets' => public_path('vendor/wshovius'),
        ], 'hoviusnetconnect.views');*/

        // Publishing the translation files.
        /*$this->publishes([
            __DIR__.'/../resources/lang' => resource_path('lang/vendor/wshovius'),
        ], 'hoviusnetconnect.views');*/

        // Registering package commands.
        // $this->commands([]);
    }
}
