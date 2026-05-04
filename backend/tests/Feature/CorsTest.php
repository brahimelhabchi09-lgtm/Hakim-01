<?php

namespace Tests\Feature;

use Tests\TestCase;

class CorsTest extends TestCase
{
    public function test_cors_headers_are_present()
    {
        $response = $this->options('/api/produits', [
            'Origin' => 'http://localhost:3000',
            'Access-Control-Request-Method' => 'GET',
        ]);
        $response->assertHeader('Access-Control-Allow-Origin');
    }
}
