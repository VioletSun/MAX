<?php

namespace VioletSun\MAX;

use Illuminate\Support\ServiceProvider;

class MAXServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot(): void
    {
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'violetsun');
        // $this->loadViewsFrom(__DIR__.'/../resources/views', 'violetsun');
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
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
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/max.php', 'max');

        // Register the service the package provides.
//        $this->app->singleton('max', function ($app) {
//            return new MAX;
//        });

        // Client
        $this->app->singleton(Client::class, function ($app) {
            $config = $app['config']->get('max', []);
            return new Client(
                baseUri: $config['base_uri'] ?? null,
                apiKey: $config['api_key'] ?? null,
                timeout: $config['timeout'] ?? null,
                saveData: $config['save_data'] ?? false,
            );
        });

        // Api (uses Client)
        $this->app->singleton(Api::class, function ($app) {
            $config = $app['config']->get('max', []);
            return new Api($app->make(Client::class), $config);
        });

        // Alias for the facade
        $this->app->alias(Api::class, 'max.api');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides(): array
    {
        return ['max'];
    }

    /**
     * Console-specific booting.
     *
     * @return void
     */
    protected function bootForConsole(): void
    {
        // Publishing the configuration file.
        $this->publishes([
            __DIR__ . '/../config/max.php' => config_path('max.php'),
        ], 'max-config');

        $this->publishes([
            __DIR__.'/../database/migrations' => database_path('migrations'),
        ], 'max-migrations');

        // Registering package commands.
        // $this->commands([]);
    }
}
