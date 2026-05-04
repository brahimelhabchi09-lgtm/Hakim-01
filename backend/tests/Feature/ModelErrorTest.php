<?php

namespace Tests\Feature;

use Tests\TestCase;

class ModelErrorTest extends TestCase
{
    public function test_not_found_returns_404()
    {
        $response = $this->getJson('/api/produits/non-existent-slug');
        $response->assertNotFound();
    }
}
