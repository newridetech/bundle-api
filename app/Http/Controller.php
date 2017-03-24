<?php

namespace Absolvent\api\Http;

use Absolvent\api\AppSwaggerValidator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

abstract class Controller extends BaseController
{
    public $appSwaggerValidator;

    abstract public function createResponse(array $properties): JsonResponse;

    public function __construct(AppSwaggerValidator $appSwaggerValidator)
    {
        $this->appSwaggerValidator = $appSwaggerValidator;
    }

    public function handleRequest(Request $request)
    {
        $response = $this->createResponse([]);

        // validate data according to Swagger schema then throw invalid data
        // exception on failure; assertions are zero-cost in production,
        // duplicate code is used to fully utilize performance advantages of
        // 'assert' language construct (PHP7+)
        // http://php.net/manual/en/function.assert.php
        assert(
            $this->appSwaggerValidator->validateResponse($request, $response)->isValid(),
            $this->appSwaggerValidator->validateResponse($request, $response)->getException()
        );

        return $response;
    }
}
