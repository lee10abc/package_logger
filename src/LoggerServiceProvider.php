<?php

declare(strict_types=1);

namespace Jean\Logger;

use Illuminate\Support\ServiceProvider;
use Jean\Logger\Middleware\LogAccess;

class LoggerServiceProvider extends ServiceProvider
{
    public function register(): void {
        // Add configuration with prefix logger
        $this->mergeConfigFrom(__DIR__ . '/../config/logger.php', 'logger');
    }

    public function boot(): void
    {
        // Publish configuration
        $this->publishes([
            __DIR__ . '/../config/logger.php' => config_path('logger.php'),
        ], 'config');

        // Register middleware
        app('router')->aliasMiddleware('log.access', LogAccess::class);

        // Publish database
        $this->publishes([
            __DIR__ . '/../database/migrations/' => database_path('migrations'),
        ], 'migrations');
    }
}
