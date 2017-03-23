<?php

namespace Absolvent\api;

use Absolvent\swagger\Breadcrumbs\RequestPath\RequestMethod as RequestMethodBreadcrumbs;

class SwaggerRouteAction
{
    const NAMESPACE_SEPARATOR = '\\';

    public $requestMethodBreadcrumbs;

    public function __construct(RequestMethodBreadcrumbs $requestMethodBreadcrumbs)
    {
        $this->requestMethodBreadcrumbs = $requestMethodBreadcrumbs;
    }

    public function getAction(string $namespace): string
    {
        [, $pathname, $method] = $this->requestMethodBreadcrumbs->breadcrumbs;

        return implode([
            $namespace,
            str_replace('/', self::NAMESPACE_SEPARATOR, $pathname),
            self::NAMESPACE_SEPARATOR,
            $method,
            '@',
            $this->getMethod(),
        ]);
    }

    public function getMethod(): string
    {
        return 'handleRequest';
    }
}
