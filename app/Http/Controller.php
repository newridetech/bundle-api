<?php

namespace Newride\api\Http;

use Newride\api\AppSwaggerSchema;
use Newride\swagger\RequestParameters;
use Newride\swagger\SwaggerSchema;
use Newride\swagger\SwaggerValidator;
use Newride\swagger\SwaggerValidator\HttpRequest as HttpRequestValidator;
use Newride\swagger\SwaggerValidator\HttpResponse as HttpResponseValidator;
use App;
use Illuminate\Routing\Controller as BaseController;
use stdClass;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

abstract class Controller extends BaseController
{
    abstract public function createResponse(stdClass $parameters): Response;

    public static function validateHttpRequest(SwaggerSchema $swaggerSchema, SwaggerValidator $swaggerValidator): void
    {
        // this is pretty straightforward; good swagger.yml file should be
        // enough to fully validate incoming request parameters
        $httpRequestValidtionResult = $swaggerValidator->validateAgainst($swaggerSchema);
        if (!$httpRequestValidtionResult->isValid()) {
            throw $httpRequestValidtionResult->getException();
        }
    }

    public static function validateHttpResponse(SwaggerSchema $swaggerSchema, SwaggerValidator $swaggerValidator): void
    {
        // validate data according to Swagger schema then throw invalid data
        // exception on failure; assertions are zero-cost in production,
        // duplicate code is used to fully utilize performance advantages of
        // 'assert' language construct (PHP7+)
        // http://php.net/manual/en/function.assert.php
        assert(
            $swaggerValidator->validateAgainst($swaggerSchema)->isValid(),
            $swaggerValidator->validateAgainst($swaggerSchema)->getException()
        );
    }

    final public function handleRequest(Request $request): Response
    {
        // do not pass global SwaggerSchema through constructor's DI to make it
        // easier for a developer to use (and be more defensive):
        // 1. passing SwaggerSchema object through controller constructor would
        //    no longer be necessary
        // 2. it would be harder to override application swagger schema than
        //    as if it would be assigned to some class property
        $swaggerSchema = App::make(AppSwaggerSchema::class);

        // validation should not be stateful; static function makes it harder
        // to create stateful validation
        static::validateHttpRequest($swaggerSchema, new HttpRequestValidator($request));

        $parameters = (new RequestParameters($request))->getDataBySwaggerSchema($swaggerSchema);

        // only parameters defined in swagger schema should passed into this
        // method (instead of Request object) to enforce correct API
        // documentation in swagger.yml
        $response = $this->createResponse($parameters);

        // response and request validation should be stateless; static
        // functions make it harder to break this
        static::validateHttpResponse($swaggerSchema, new HttpResponseValidator($request, $response));

        return $response;
    }
}
