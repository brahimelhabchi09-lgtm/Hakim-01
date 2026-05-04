<?php

namespace Tests\Feature;

use Tests\TestCase;

class NotFoundTest extends TestCase
{
    public function test_404_for_unknown_route()
    {
        $response = $this->getJson('/api/unknown-route');
        $response->assertNotFound();
    }
}
