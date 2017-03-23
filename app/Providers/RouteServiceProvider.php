<?php

namespace Absolvent\api\Providers;

use Absolvent\api\AppSwaggerSchema;
use Absolvent\api\SwaggerRouteLoader;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'Absolvent\api\fixtures\api';

    /**
     * Define your route model bindings, pattern filters, etc.
     */
    public function boot()
    {
        parent::boot();
    }

    /**
     * Define the routes for the application.
     */
    public function map()
    {
        $this->mapApiRoutes();
        $this->mapWebRoutes();
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     */
    protected function mapWebRoutes()
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/web.php'))
        ;
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     */
    protected function mapApiRoutes()
    {
        $router = $this->app->make('router');
        $swaggerSchema = $this->app->make(AppSwaggerSchema::class);

        $swaggerRouteLoader = SwaggerRouteLoader::fromSwaggerSchema($swaggerSchema);

        foreach ($swaggerRouteLoader->getSwaggerRoutes() as $swaggerRoute) {
            $router->match(
                $swaggerRoute->getMethod(),
                $swaggerRoute->getUri(),
                $swaggerRoute->swaggerRouteAction->getAction($this->namespace)
            );
        }
    }
}
