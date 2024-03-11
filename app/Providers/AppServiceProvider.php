<?php

namespace App\Providers;

use App\ApiUser;
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
        $this->app->singleton(ApiUser::class, function ($app) {
            return new ApiUser();
        });
    }
}
