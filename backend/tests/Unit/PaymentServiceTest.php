<?php

namespace Tests\Unit;

use App\Services\PaymentService;
use Tests\TestCase;

class PaymentServiceTest extends TestCase
{
    public function test_generate_transaction_id()
    {
        $service = new PaymentService();
        $method = new \ReflectionMethod($service, 'generateTransactionId');
        $method->setAccessible(true);
        $id = $method->invoke($service);
        $this->assertStringStartsWith('TXN-', $id);
        $this->assertEquals(19, strlen($id));
    }
}
