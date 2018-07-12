<?php

namespace App\Providers;

use App\Services\MI6\CacheSecret;
use App\Services\MI6\DatabaseSecret;
use App\Services\MI6\SecretService;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(SecretService::class, function ($app) {
            \Log::info($app->config['secret']['provider']);
            if ($app->config['secret']['provider'] == 'cache') {
                return new CacheSecret();
            }

            return new DatabaseSecret();
        });
    }
}
