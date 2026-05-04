<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Origin extends Model
{
    protected $fillable = [
        'pays', 'code', 'drapeau', 'description',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($origin) {
            if (empty($origin->code)) {
                $origin->code = Str::upper(Str::substr($origin->pays, 0, 2));
            }
        });
    }
}
