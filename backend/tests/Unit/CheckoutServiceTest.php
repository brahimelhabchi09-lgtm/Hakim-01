<?php

namespace Tests\Unit;

use App\Models\User;
use App\Models\Produit;
use App\Services\CheckoutService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CheckoutServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_generate_order_number()
    {
        $service = new CheckoutService();
        $method = new \ReflectionMethod($service, 'generateNumero');
        $method->setAccessible(true);
        $numero = $method->invoke($service);
        $this->assertMatchesRegularExpression('/^CMD-\d{6}$/', $numero);
    }
}
