<?php

namespace Newride\api\Providers;

use Newride\api\AppSwaggerSchema;
use Newride\api\SwaggerRouteLoader;
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
    protected $namespace = 'Newride\api\fixtures\api';

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
        $basePath = $swaggerSchema->get('basePath');

        $swaggerRouteLoader = SwaggerRouteLoader::fromSwaggerSchema($swaggerSchema);

        foreach ($swaggerRouteLoader->getSwaggerRoutes() as $swaggerRoute) {
            $router->match(
                $swaggerRoute->getMethod(),
                $swaggerRoute->getUri($basePath),
                $swaggerRoute->swaggerRouteAction->getAction($this->namespace)
            );
        }
    }
}
