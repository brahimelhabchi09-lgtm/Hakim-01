<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Tag;

class TagController extends Controller
{
    public function index()
    {
        return Tag::withCount('produits')
            ->where('produits_count', '>', 0)
            ->orderBy('nom')
            ->get();
    }

    public function show(Tag $tag)
    {
        return $tag->load('produits');
    }
}
