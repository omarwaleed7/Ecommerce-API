<?php

namespace App\Providers;

use App\Contracts\BaseRepositoryInterface;
use App\Contracts\BaseServiceInterface;
use App\Repositories\BaseRepository;
use Illuminate\Support\ServiceProvider;

class BaseRepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(BaseRepositoryInterface::class, function ($app) {
            return new BaseRepository($app->make(BaseServiceInterface::class));
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
