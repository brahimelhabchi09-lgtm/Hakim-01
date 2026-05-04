<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;

trait HasMedia
{
    public function getImageUrlAttribute(): ?string
    {
        return $this->image ? Storage::url($this->image) : null;
    }

    public function getGalleryUrlsAttribute(): array
    {
        return collect($this->galerie ?? [])
            ->map(fn($path) => Storage::url($path))
            ->toArray();
    }
}
