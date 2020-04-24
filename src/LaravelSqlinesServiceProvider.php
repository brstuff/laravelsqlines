<?php

namespace brstuff\LaravelSqlines;

use Illuminate\Support\ServiceProvider;

class LaravelSqlinesServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'brstuff');
        // $this->loadViewsFrom(__DIR__.'/../resources/views', 'brstuff');
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
        $this->mergeConfigFrom(__DIR__.'/../config/laravelsqlines.php', 'laravelsqlines');

        // Register the service the package provides.
        $this->app->singleton('laravelsqlines', function ($app) {
            return new LaravelSqlines;
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['laravelsqlines'];
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
            __DIR__.'/../config/laravelsqlines.php' => config_path('laravelsqlines.php'),
        ], 'laravelsqlines.config');

        // Publishing the views.
        /*$this->publishes([
            __DIR__.'/../resources/views' => base_path('resources/views/vendor/brstuff'),
        ], 'laravelsqlines.views');*/

        // Publishing assets.
        /*$this->publishes([
            __DIR__.'/../resources/assets' => public_path('vendor/brstuff'),
        ], 'laravelsqlines.views');*/

        // Publishing the translation files.
        /*$this->publishes([
            __DIR__.'/../resources/lang' => resource_path('lang/vendor/brstuff'),
        ], 'laravelsqlines.views');*/

        // Registering package commands.
        // $this->commands([]);
        
        $this->publishes([
            __DIR__.'/../resources/sqlines' => storage_path('laravelsqlines'),
        ], 'laravelsqlines.app');
        
    }
}
