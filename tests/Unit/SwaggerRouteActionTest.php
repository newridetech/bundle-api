<?php

namespace Newride\api\tests\Unit;

use Newride\api\SwaggerRouteAction;
use Newride\swagger\Breadcrumbs\RequestPath\RequestMethod as RequestMethodBreadcrumbs;
use PHPUnit\Framework\TestCase;

class SwaggerRouteActionTest extends TestCase
{
    public function provideRequestMethodBreadcrumbs()
    {
        yield '' => [
            'requestMethodBreadcrumbs' => new RequestMethodBreadcrumbs([
                'paths',
                '/pet',
                'get',
            ]),
            'namespace' => 'Foo\Bar',
            'expectedAction' => 'Foo\Bar\pet\Get@handleRequest',
        ];
    }

    /**
     * @dataProvider provideRequestMethodBreadcrumbs
     */
    public function testThatRouteActionIsGenerated(RequestMethodBreadcrumbs $requestMethodBreadcrumbs, string $namespace, string $expectedAction)
    {
        $swaggerRouteAction = new SwaggerRouteAction($requestMethodBreadcrumbs);

        self::assertEquals($expectedAction, $swaggerRouteAction->getAction($namespace));
    }
}
