<?php

namespace Tests\Unit;

use App\Services\ImageService;
use Tests\TestCase;

class ImageServiceTest extends TestCase
{
    public function test_upload_generates_filename()
    {
        $this->markTestSkipped('Requires file upload mocking');
    }
}
