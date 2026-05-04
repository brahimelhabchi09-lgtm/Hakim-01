<?php

namespace Tests\Feature;

use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategorieApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_list_categories()
    {
        Category::factory()->count(3)->create();
        $response = $this->getJson('/api/categories');
        $response->assertOk()->assertJsonCount(3, 'data');
    }

    public function test_show_category_by_slug()
    {
        $category = Category::factory()->create(['slug' => 'electronics']);
        $response = $this->getJson('/api/categories/electronics');
        $response->assertOk()->assertJsonPath('data.slug', 'electronics');
    }
}
