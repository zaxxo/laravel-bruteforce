<?php

namespace Zaxxo\LaravelBruteforce;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

/**
 * Service provider for bruteforce protection package.
 *
 * @package Zaxxo\LaravelBruteforce
 * @internal
 */
class ServiceProvider extends BaseServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->registerMiddlewares();

        if ($this->app->runningInConsole()) {
            $this->registerMigrations();
            $this->registerCommands();
            $this->registerSchedules();
        }
    }

    /**
     * Register middlewares.
     */
    protected function registerMiddlewares(): void
    {
        $router = $this->app->get(Router::class);

        $router->middlewarePriority[] = Middleware::class;

        $router->aliasMiddleware('bruteforce', Middleware::class);
    }

    /**
     * Register migrations.
     */
    protected function registerMigrations(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
    }

    /**
     * Register commands.
     */
    protected function registerCommands(): void
    {
        $this->commands(CleanupCommand::class);
    }

    /**
     * Register schedules.
     */
    protected function registerSchedules(): void
    {
        $this->app->booted(function () {
            $schedule = $this->app->get(Schedule::class);
            $schedule->command('bruteforce:clean')->hourly();
        });
    }
}
