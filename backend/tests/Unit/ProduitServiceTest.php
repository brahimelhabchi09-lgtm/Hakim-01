<?php

namespace Tests\Unit;

use App\Services\ProduitService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProduitServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_search_returns_query_builder()
    {
        $service = new ProduitService();
        $query = $service->search();
        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Builder::class, $query);
    }

    public function test_search_applies_category_filter()
    {
        $service = new ProduitService();
        $query = $service->search(['category_id' => 1]);
        $this->assertStringContainsString('category_id', $query->toSql());
    }
}
