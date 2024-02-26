<?php

namespace App\Providers;

use App\Services\Cache\CacheLayer;
use App\Services\Cache\Contract\CacheContract;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->app->singleton(CacheContract::class, CacheLayer::class);
    }
}
