<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Origin;
use Illuminate\Http\Request;

class AdminOriginController extends Controller
{
    public function index()
    {
        return Origin::withCount('produits')->latest()->paginate(20);
    }

    public function store(Request $request)
    {
        $data = $request->validate(['nom' => 'required|string|max:255']);
        $origin = Origin::create($data);
        return response()->json($origin, 201);
    }

    public function update(Request $request, Origin $origin)
    {
        $data = $request->validate(['nom' => 'required|string|max:255']);
        $origin->update($data);
        return response()->json($origin);
    }

    public function destroy(Origin $origin)
    {
        $origin->delete();
        return response()->json(null, 204);
    }
}
