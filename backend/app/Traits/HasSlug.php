<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait HasSlug
{
    protected static function bootHasSlug(): void
    {
        static::creating(function ($model) {
            if (!$model->slug) {
                $model->slug = Str::slug($model->nom);
            }
        });
    }
}
