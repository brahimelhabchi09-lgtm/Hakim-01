<?php

namespace Tests\Feature;

use Tests\TestCase;

class ApiVersioningTest extends TestCase
{
    public function test_api_responds_on_default_prefix()
    {
        $response = $this->getJson('/api/health');
        $response->assertOk();
    }
}
