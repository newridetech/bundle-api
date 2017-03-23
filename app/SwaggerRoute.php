<?php

namespace Absolvent\api;

use Absolvent\swagger\Breadcrumbs\RequestPath\RequestMethod as RequestMethodBreadcrumbs;
use League\Uri\Components\HierarchicalPath;

class SwaggerRoute
{
    public $requestMethodBreadcrumbs;
    public $swaggerRouteAction;

    public function __construct(RequestMethodBreadcrumbs $requestMethodBreadcrumbs)
    {
        $this->requestMethodBreadcrumbs = $requestMethodBreadcrumbs;
        $this->swaggerRouteAction = new SwaggerRouteAction($this->requestMethodBreadcrumbs);
    }

    public function getMethod(): string
    {
        return $this->requestMethodBreadcrumbs->breadcrumbs[2];
    }

    public function getUri(string $basePath): string
    {
        $path = new HierarchicalPath($this->requestMethodBreadcrumbs->breadcrumbs[1]);
        $path = $path->prepend($basePath);

        return strval($path);
    }
}
