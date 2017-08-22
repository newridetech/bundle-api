<?php

namespace Absolvent\api\Providers;

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
        if ($this->app->environment() !== 'production' && class_exists(IdeHelperServiceProvider::class)) {
            $this->app->register(IdeHelperServiceProvider::class);
        }
    }
}
