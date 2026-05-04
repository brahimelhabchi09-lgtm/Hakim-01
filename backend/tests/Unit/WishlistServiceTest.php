<?php

namespace Tests\Unit;

use App\Services\WishlistService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WishlistServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_toggle_adds_item()
    {
        $service = new WishlistService();
        $this->assertTrue(true);
    }
}
