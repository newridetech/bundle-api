<?php

namespace Absolvent\api\Http;

use Absolvent\api\AppSwaggerSchema;
use Absolvent\swagger\SwaggerValidator;
use Absolvent\swagger\SwaggerValidator\HttpRequest as HttpRequestValidator;
use Absolvent\swagger\SwaggerValidator\HttpResponse as HttpResponseValidator;
use Illuminate\Routing\Controller as BaseController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

abstract class Controller extends BaseController
{
    public $swaggerSchema;

    abstract public function createResponse(Request $request): Response;

    public function __construct(AppSwaggerSchema $swaggerSchema)
    {
        $this->swaggerSchema = $swaggerSchema;
    }

    public function validateSchema(SwaggerValidator $swaggerValidator): void
    {
        // validate data according to Swagger schema then throw invalid data
        // exception on failure; assertions are zero-cost in production,
        // duplicate code is used to fully utilize performance advantages of
        // 'assert' language construct (PHP7+)
        // http://php.net/manual/en/function.assert.php
        assert(
            $swaggerValidator->validateAgainst($this->swaggerSchema)->isValid(),
            $swaggerValidator->validateAgainst($this->swaggerSchema)->getException()
        );
    }

    public function handleRequest(Request $request): Response
    {
        $this->validateSchema(new HttpRequestValidator($request));

        $response = $this->createResponse($request);

        $this->validateSchema(new HttpResponseValidator($request, $response));

        return $response;
    }
}
