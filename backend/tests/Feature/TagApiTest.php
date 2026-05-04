<?php

namespace Tests\Feature;

use App\Models\Tag;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TagApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_list_tags()
    {
        Tag::factory()->count(3)->create();
        $response = $this->getJson('/api/tags');
        $response->assertOk();
    }
}
