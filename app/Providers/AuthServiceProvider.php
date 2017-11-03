<?php

namespace Newride\api\Providers;

use Newride\api\app\Auth\JwtAuthenticationGuard;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Codecasts\Auth\JWT\Token\Manager;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register any authentication / authorization services.
     */
    public function boot()
    {
        $this->app->bind(JwtAuthenticationGuard::class, function () {
            return new JwtAuthenticationGuard(JwtAuthenticationGuard::getTokenFromRequest(
                $this->app->make(Manager::class),
                $this->app->make('request')
            ));
        });

        Auth::extend('jwt', function () {
            return $this->app->make(JwtAuthenticationGuard::class);
        });
    }
}
