<?php

namespace Absolvent\api\tests\Feature;

use Absolvent\api\TestCase;

class PetstoreSwaggerTest extends TestCase
{
    public function testBasicTest()
    {
        $response = $this->get('/api/pet');

        $response->assertStatus(200);
    }
}
