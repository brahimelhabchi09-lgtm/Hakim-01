<?php

namespace Tests\Unit;

use Tests\TestCase;

class HelpersTest extends TestCase
{
    public function test_format_price()
    {
        $this->assertEquals('99.99 MAD', format_price(99.99));
    }

    public function test_format_price_with_currency()
    {
        $this->assertEquals('50.00 USD', format_price(50.00, 'USD'));
    }

    public function test_format_date()
    {
        $result = format_date('2024-01-15');
        $this->assertEquals('15/01/2024', $result);
    }
}
