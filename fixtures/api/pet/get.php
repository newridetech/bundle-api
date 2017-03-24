<?php

namespace Absolvent\api\fixtures\api\pet;

use Absolvent\api\Http\Controller;
use Illuminate\Http\JsonResponse;

class get extends Controller
{
    public function createResponse(array $properties): JsonResponse
    {
        return response()->json([
            [
                'pet_id' => 1,
                'pet_name' => 'hihi',
            ],
        ]);
    }
}
