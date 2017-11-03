<?php

namespace Newride\api\tests\Unit;

use Newride\api\SwaggerRoute;
use Newride\api\SwaggerRouteLoader;
use Newride\swagger\SwaggerSchema;
use Illuminate\Foundation\Testing\TestCase;
use Newride\api\tests\CreatesApplication;

class SwaggerRouteLoaderTest extends TestCase
{
    use CreatesApplication;

    public function testThatRouteListIsLoaded()
    {
        $swaggerSchema = SwaggerSchema::fromFilename(base_path(env('SWAGGER_FILENAME')));
        $swaggerRouteLoader = SwaggerRouteLoader::fromSwaggerSchema($swaggerSchema);
        $swaggerRoutes = $swaggerRouteLoader->getSwaggerRoutes();

        self::assertNotEmpty($swaggerRoutes);
        self::assertContainsOnlyInstancesOf(SwaggerRoute::class, $swaggerRoutes);
    }
}
