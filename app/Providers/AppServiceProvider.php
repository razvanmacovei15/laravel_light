<?php

namespace App\Providers;

use App\Services\Logger;
use Framework\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(Logger::class, function () {
            return new Logger();
        });
    }
}