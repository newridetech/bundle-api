<?php

namespace Absolvent\api\Http;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

abstract class Controller extends BaseController
{
    abstract public function createResponse(array $properties): JsonResponse;

    public function handleRequest(Request $request)
    {
        $response = $this->createResponse([]);

        // validate data according to Swagger schema then throw invalid data
        // exception on failure
        assert($response->getData());
    }
}
