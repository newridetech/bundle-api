<?php

namespace Absolvent\api\Http;

use Absolvent\api\AppSwaggerValidator;
use Illuminate\Routing\Controller as BaseController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

abstract class Controller extends BaseController
{
    public $appSwaggerValidator;

    abstract public function createResponse(Request $request): Response;

    public function __construct(AppSwaggerValidator $appSwaggerValidator)
    {
        $this->appSwaggerValidator = $appSwaggerValidator;
    }

    public function handleRequest(Request $request)
    {
        $response = $this->createResponse($request);

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
