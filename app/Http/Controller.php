<?php

namespace Absolvent\api\Http;

use Illuminate\Routing\Controller as BaseController;

abstract class Controller extends BaseController
{
    abstract public function sendResponse(array $properties);
}
