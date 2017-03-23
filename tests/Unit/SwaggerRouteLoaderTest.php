<?php

namespace Absolvent\api\tests\Unit;

use Absolvent\api\SwaggerRoute;
use Absolvent\api\SwaggerRouteLoader;
use Absolvent\api\tests\TestCase;
use Absolvent\swagger\SwaggerSchema;

class SwaggerRouteLoaderTest extends TestCase
{
    public function testThatRouteListIsLoaded()
    {
        $swaggerSchema = SwaggerSchema::fromFilename(env('SWAGGER_FILENAME'));
        $swaggerRouteLoader = SwaggerRouteLoader::fromSwaggerSchema($swaggerSchema);
        $swaggerRoutes = $swaggerRouteLoader->getSwaggerRoutes();

        $this->assertNotEmpty($swaggerRoutes);
        $this->assertContainsOnlyInstancesOf(SwaggerRoute::class, $swaggerRoutes);
    }
}
