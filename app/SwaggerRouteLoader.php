<?php

namespace Absolvent\api;

use Absolvent\swagger\Breadcrumbs\RequestPath\RequestMethod as RequestMethodBreadcrumbs;
use Absolvent\swagger\SwaggerSchema;
use Absolvent\swagger\SwaggerSchemaRequestMethods;

class SwaggerRouteLoader
{
    public $swaggerSchemaRequestMethods;

    public static function fromSwaggerSchema(SwaggerSchema $swaggerSchema)
    {
        return new static(new SwaggerSchemaRequestMethods($swaggerSchema));
    }

    public function __construct(SwaggerSchemaRequestMethods $swaggerSchemaRequestMethods)
    {
        $this->swaggerSchemaRequestMethods = $swaggerSchemaRequestMethods;
    }

    public function getSwaggerRoutes(): array
    {
        return array_map(function (RequestMethodBreadcrumbs $requestMethod) {
            return new SwaggerRoute($requestMethod);
        }, $this->swaggerSchemaRequestMethods->getRequestMethodBreadcrumbsList());
    }
}
