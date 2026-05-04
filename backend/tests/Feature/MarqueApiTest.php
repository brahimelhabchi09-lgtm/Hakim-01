<?php

namespace Tests\Feature;

use App\Models\Marque;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MarqueApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_list_marques()
    {
        Marque::factory()->count(4)->create();
        $response = $this->getJson('/api/marques');
        $response->assertOk()->assertJsonCount(4, 'data');
    }

    public function test_show_marque_by_slug()
    {
        $marque = Marque::factory()->create(['slug' => 'test-brand']);
        $response = $this->getJson('/api/marques/test-brand');
        $response->assertOk()->assertJsonPath('data.slug', 'test-brand');
    }
}
