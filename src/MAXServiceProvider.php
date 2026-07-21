<?php

namespace VioletSun\MAX;

use Illuminate\Support\Facades\Route;
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
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'max');
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'max');
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

//        $this->loadRoutesFrom(__DIR__.'/../routes/max.php');
        $this->registerRoutes();

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

        // Client
        $this->app->singleton(Client::class, function ($app) {
            $config = $app['config']->get('max', []);
            return new Client(
                baseUri: $config['base_uri'] ?? null,
                apiKey: $config['api_key'] ?? null,
                timeout: $config['timeout'] ?? null,
                saveData: $config['save_data'] ?? false,
                enqueue: $config['enqueue'] ?? false,
            );
        });

        // Api (uses Client)
        $this->app->singleton(Api::class, function ($app) {
            return new Api($app->make(Client::class));
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
            __DIR__ . '/../database/migrations' => database_path('migrations'),
        ], 'max-migrations');

        $this->publishes([
            __DIR__ . '/Models' => app_path('Models'),
        ], 'max-models');

        $this->publishes([
            __DIR__ . '/../public' => public_path('vendor/violetsun/max'),
        ], 'max-assets');

        $this->publishes([
            __DIR__ . '/Services' => app_path('Services/Max'),
        ], 'max-services');

        // Registering package commands.
        // $this->commands([]);
    }

    /**
     * Register the package routes with explicit configuration.
     */
    protected function registerRoutes(): void
    {
        if (!config('max.routes.enabled', true)) {
            return;
        }
        Route::group($this->routeConfiguration(), function () {
            $this->loadRoutesFrom(__DIR__ . '/../routes/max.php');
        });
    }

    /**
     * Define the route group configuration.
     */
    protected function routeConfiguration(): array
    {
        return [
            'prefix' => config('max.routes.prefix', 'api'),     // Optional: Adds a versioned path prefix
            'middleware' => config('max.routes.middleware', ['api']), // Crucial: Applies stateless API middleware group
        ];
    }
}
