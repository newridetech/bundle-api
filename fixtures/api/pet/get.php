<?php

namespace Absolvent\api\fixtures\api\pet;

use Absolvent\api\Http\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class get extends Controller
{
    public function createResponse(Request $request): Response
    {
        return response()->json([
            [
                'pet_id' => 1,
                'pet_name' => 'hihi',
            ],
        ]);
    }
}
