<?php

namespace App\Providers;

use App\Contracts\BaseServiceInterface;
use App\Services\BaseService;
use Illuminate\Support\ServiceProvider;

class BaseServiceServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(BaseServiceInterface::class, function ($app) {
            return new BaseService();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
