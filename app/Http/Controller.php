<?php

namespace Absolvent\api\Http;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

abstract class Controller extends BaseController
{
    abstract public function sendResponse(array $properties);

    public function handleRequest(Request $request)
    {
        assert(true);

        return $this->sendResponse([]);
    }
}
