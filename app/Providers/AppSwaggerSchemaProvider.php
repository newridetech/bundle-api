<?php

namespace Absolvent\api\Providers;

use Absolvent\api\AppSwaggerSchema;
use Illuminate\Support\ServiceProvider;

class AppSwaggerSchemaProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
    }

    public function provides(): array
    {
        return [
            AppSwaggerSchema::class,
        ];
    }

    /**
     * Register any application services.
     */
    public function register()
    {
        $this->app->bind(AppSwaggerSchema::class, function () {
            $swaggerFilename = env('SWAGGER_FILENAME', 'swagger.yml');
            return AppSwaggerSchema::fromFilename(base_path($swaggerFilename));
        });
    }
}
