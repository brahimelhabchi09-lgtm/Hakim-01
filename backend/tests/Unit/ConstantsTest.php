<?php

namespace Tests\Unit;

use App\Constants\OrderStatus;
use App\Constants\PaymentStatus;
use App\Constants\PaymentMethod;
use App\Constants\ProductStatus;
use Tests\TestCase;

class ConstantsTest extends TestCase
{
    public function test_order_status_values()
    {
        $this->assertEquals('en_cours', OrderStatus::EN_COURS);
        $this->assertEquals('livree', OrderStatus::LIVREE);
        $this->assertCount(5, OrderStatus::all());
    }

    public function test_payment_status_values()
    {
        $this->assertEquals('pending', PaymentStatus::PENDING);
        $this->assertCount(4, PaymentStatus::all());
    }

    public function test_payment_method_values()
    {
        $this->assertEquals('stripe', PaymentMethod::STRIPE);
        $this->assertCount(3, PaymentMethod::all());
    }

    public function test_product_status_values()
    {
        $this->assertEquals('actif', ProductStatus::ACTIF);
        $this->assertCount(3, ProductStatus::all());
    }
}
