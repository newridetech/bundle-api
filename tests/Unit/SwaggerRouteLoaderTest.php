<?php

namespace Absolvent\api\tests\Unit;

use Absolvent\api\SwaggerRoute;
use Absolvent\api\SwaggerRouteLoader;
use Absolvent\swagger\SwaggerSchema;
use PHPUnit\Framework\TestCase;

class SwaggerRouteLoaderTest extends TestCase
{
    public function testThatRouteListIsLoaded()
    {
        $swaggerSchema = SwaggerSchema::fromFilename(base_path(env('SWAGGER_FILENAME')));
        $swaggerRouteLoader = SwaggerRouteLoader::fromSwaggerSchema($swaggerSchema);
        $swaggerRoutes = $swaggerRouteLoader->getSwaggerRoutes();

        self::assertNotEmpty($swaggerRoutes);
        self::assertContainsOnlyInstancesOf(SwaggerRoute::class, $swaggerRoutes);
    }
}
