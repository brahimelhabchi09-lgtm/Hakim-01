<?php

namespace Tests\Feature;

use Tests\TestCase;

class HealthCheckTest extends TestCase
{
    public function test_health_endpoint()
    {
        $response = $this->getJson('/api/health');
        $response->assertOk()->assertJson(['status' => 'ok']);
    }
}
