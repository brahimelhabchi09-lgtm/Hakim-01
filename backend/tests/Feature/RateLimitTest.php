<?php

namespace Tests\Feature;

use Tests\TestCase;

class RateLimitTest extends TestCase
{
    public function test_api_rate_limiting()
    {
        for ($i = 0; $i < 60; $i++) {
            $response = $this->getJson('/api/produits');
        }
        $response = $this->getJson('/api/produits');
        $response->assertHeader('X-RateLimit-Remaining');
    }
}
