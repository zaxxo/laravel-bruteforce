<?php

namespace Zaxxo\LaravelBruteforce;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;

/**
 * Service provider for bruteforce protection package.
 *
 * @package Zaxxo\LaravelBruteforce
 * @internal
 */
class BruteforceServiceProvider extends ServiceProvider
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

        $router->middlewarePriority[] = BruteforceMiddleware::class;

        $router->aliasMiddleware('bruteforce', BruteforceMiddleware::class);
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
