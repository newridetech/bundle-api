<?php

namespace Newride\api\Providers;

use Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
    }

    /**
     * Register any application services.
     */
    public function register()
    {
        if ('production' !== $this->app->environment() && class_exists(IdeHelperServiceProvider::class)) {
            $this->app->register(IdeHelperServiceProvider::class);
        }
    }
}
