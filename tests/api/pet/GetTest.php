<?php

namespace Newride\api\tests\Feature;

use Newride\api\TestCase;

class PetstoreSwaggerTest extends TestCase
{
    public function testBasicTest()
    {
        $response = $this->get('/api/pet');

        $response->assertStatus(200);
    }
}
