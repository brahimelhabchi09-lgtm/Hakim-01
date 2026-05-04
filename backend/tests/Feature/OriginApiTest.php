<?php

namespace Tests\Feature;

use App\Models\Origin;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OriginApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_list_origins()
    {
        Origin::factory()->count(3)->create();
        $response = $this->getJson('/api/origins');
        $response->assertOk();
    }
}
