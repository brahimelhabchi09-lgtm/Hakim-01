<?php

namespace App\Traits;

trait Rateable
{
    public function averageRating(): float
    {
        return (float) round($this->avis()->avg('note') ?? 0, 1);
    }

    public function ratingCount(): int
    {
        return $this->avis()->count();
    }
}
