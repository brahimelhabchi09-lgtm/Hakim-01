<?php

namespace Tests\Unit;

use Tests\TestCase;

class TraitsTest extends TestCase
{
    public function test_has_slug_trait_exists()
    {
        $this->assertTrue(trait_exists(\App\Traits\HasSlug::class));
    }

    public function test_has_uuid_trait_exists()
    {
        $this->assertTrue(trait_exists(\App\Traits\HasUuid::class));
    }

    public function test_has_media_trait_exists()
    {
        $this->assertTrue(trait_exists(\App\Traits\HasMedia::class));
    }

    public function test_rateable_trait_exists()
    {
        $this->assertTrue(trait_exists(\App\Traits\Rateable::class));
    }
}
