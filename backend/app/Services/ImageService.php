<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImageService
{
    protected string $disk = 'public';

    public function uploadProduitImage(UploadedFile $file): string
    {
        return $this->upload($file, 'produits');
    }

    public function uploadGalleryImage(UploadedFile $file): string
    {
        return $this->upload($file, 'produits/galerie');
    }

    public function upload(UploadedFile $file, string $directory): string
    {
        $filename = Str::random(40) . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs($directory, $filename, $this->disk);
        return $path;
    }

    public function delete(string $path): bool
    {
        return Storage::disk($this->disk)->delete($path);
    }
}
