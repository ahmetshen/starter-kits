<?php

namespace AhmetShen\StarterKits;

use Illuminate\Support\ServiceProvider;

class StarterKitsServiceProvider extends ServiceProvider
{
    /**
     * Register the application services.
     *
     * @return void
     */
    public function register(): void
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__.'/../config/starter-kits.php', 'starter-kits');

        // Register the main class to use with the facade
        $this->app->singleton('starter-kits', function () {
            return new StarterKits;
        });
    }

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot(): void
    {
        if (! $this->app->runningInConsole()) {
            return;
        }

        // Registering package commands.
        $this->commands([
            Console\InstallCommand::class,
            Console\OptimizeConfiguration::class,
        ]);
    }
}
