<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ImageUploadTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_upload_product_image()
    {
        Storage::fake('public');
        $admin = User::factory()->create(['is_admin' => true]);
        $file = UploadedFile::fake()->image('product.jpg');
        $response = $this->actingAs($admin)->postJson('/api/admin/produits/upload', ['image' => $file]);
        $response->assertOk();
    }
}
