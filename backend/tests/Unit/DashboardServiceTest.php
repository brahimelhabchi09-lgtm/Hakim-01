<?php

namespace Tests\Unit;

use App\Services\DashboardService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_stats_returns_array()
    {
        $service = new DashboardService();
        $stats = $service->getStats();
        $this->assertIsArray($stats);
        $this->assertArrayHasKey('total_revenue', $stats);
        $this->assertArrayHasKey('total_commandes', $stats);
    }
}
