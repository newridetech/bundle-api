<?php

namespace Absolvent\api\tests\Unit;

use Absolvent\api\SwaggerRoute;
use Absolvent\api\tests\TestCase;
use Absolvent\swagger\Breadcrumbs\RequestPath\RequestMethod as RequestMethodBreadcrumbs;

class SwaggerRouteTest extends TestCase
{
    public function provideRequestMethodBreadcrumbs()
    {
        yield '' => [
            'requestMethodBreadcrumbs' => new RequestMethodBreadcrumbs([
                'paths',
                '/pet',
                'get',
            ]),
            'expectedMethod' => 'get',
            'expectedUri' => '/pet',
        ];
    }

    /**
     * @dataProvider provideRequestMethodBreadcrumbs
     */
    public function testThatRouteActionIsGenerated(RequestMethodBreadcrumbs $requestMethodBreadcrumbs, $expectedMethod, $expectedUri)
    {
        $swaggerRouteAction = new SwaggerRoute($requestMethodBreadcrumbs);

        $this->assertEquals($expectedMethod, $swaggerRouteAction->getMethod());
        $this->assertEquals($expectedUri, $swaggerRouteAction->getUri());
    }
}
