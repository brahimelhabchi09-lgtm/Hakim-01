<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Origin;

class OriginController extends Controller
{
    public function index()
    {
        return Origin::withCount('produits')
            ->where('produits_count', '>', 0)
            ->orderBy('nom')
            ->get();
    }

    public function show(Origin $origin)
    {
        return $origin->load('produits');
    }
}
