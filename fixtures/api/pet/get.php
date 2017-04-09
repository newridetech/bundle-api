<?php

namespace Absolvent\api\fixtures\api\pet;

use Absolvent\api\Http\Controller;
use stdClass;
use Symfony\Component\HttpFoundation\Response;

class get extends Controller
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
