<?php

namespace Absolvent\api\tests\Feature;

use Absolvent\api\tests\TestCase;

class PetstoreSwaggerTest extends TestCase
{
    public function testBasicTest()
    {
        $response = $this->get('/api/pet');

        // dd($response->getContent());
        $response->assertStatus(200);
    }
}
