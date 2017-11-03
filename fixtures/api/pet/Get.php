<?php

namespace Newride\api\fixtures\api\pet;

use Newride\api\Http\Controller;
use stdClass;
use Symfony\Component\HttpFoundation\Response;

class Get extends Controller
{
    public function createResponse(stdClass $parameters): Response
    {
        return response()->json([
            [
                'pet_id' => 1,
                'pet_name' => 'hihi',
            ],
        ]);
    }
}
