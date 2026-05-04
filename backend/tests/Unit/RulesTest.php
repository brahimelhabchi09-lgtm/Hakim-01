<?php

namespace Tests\Unit;

use App\Rules\ValidSlug;
use App\Rules\ValidPhoneNumber;
use Tests\TestCase;

class RulesTest extends TestCase
{
    public function test_valid_slug_passes()
    {
        $rule = new ValidSlug();
        $this->assertTrue($rule->passes('slug', 'my-product'));
    }

    public function test_invalid_slug_fails()
    {
        $rule = new ValidSlug();
        $this->assertFalse($rule->passes('slug', 'My Product!'));
    }

    public function test_valid_phone_passes()
    {
        $rule = new ValidPhoneNumber();
        $this->assertTrue($rule->passes('phone', '+212 6 00 00 00 00'));
    }

    public function test_invalid_phone_fails()
    {
        $rule = new ValidPhoneNumber();
        $this->assertFalse($rule->passes('phone', 'abc'));
    }
}
