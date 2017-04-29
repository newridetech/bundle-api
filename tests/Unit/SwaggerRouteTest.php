<?php

namespace Absolvent\api\tests\Unit;

use Absolvent\api\SwaggerRoute;
use Absolvent\swagger\Breadcrumbs\RequestPath\RequestMethod as RequestMethodBreadcrumbs;
use PHPUnit\Framework\TestCase;

class SwaggerRouteTest extends TestCase
{
    public function provideRequestMethodBreadcrumbs()
    {
        yield 'base path as a root document' => [
            'requestMethodBreadcrumbs' => new RequestMethodBreadcrumbs([
                'paths',
                '/pet',
                'get',
            ]),
            'basePath' => '/',
            'expectedMethod' => 'get',
            'expectedUri' => '/pet',
        ];

        yield 'nested base path' => [
            'requestMethodBreadcrumbs' => new RequestMethodBreadcrumbs([
                'paths',
                '/pet/foo',
                'get',
            ]),
            'basePath' => '/api',
            'expectedMethod' => 'get',
            'expectedUri' => '/api/pet/foo',
        ];
    }

    /**
     * @dataProvider provideRequestMethodBreadcrumbs
     */
    public function testThatRouteActionIsGenerated(RequestMethodBreadcrumbs $requestMethodBreadcrumbs, string $basePath, string $expectedMethod, string $expectedUri)
    {
        $swaggerRouteAction = new SwaggerRoute($requestMethodBreadcrumbs);

        self::assertEquals($expectedMethod, $swaggerRouteAction->getMethod());
        self::assertEquals($expectedUri, $swaggerRouteAction->getUri($basePath));
    }
}
