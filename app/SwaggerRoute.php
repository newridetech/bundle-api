<?php

namespace Absolvent\api;

use Absolvent\swagger\Breadcrumbs\RequestPath\RequestMethod as RequestMethodBreadcrumbs;

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

    public function getUri(): string
    {
        return $this->requestMethodBreadcrumbs->breadcrumbs[1];
    }
}
