<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\Request;

class AdminTagController extends Controller
{
    public function index()
    {
        return Tag::withCount('produits')->latest()->paginate(20);
    }

    public function store(Request $request)
    {
        $data = $request->validate(['nom' => 'required|string|max:255']);
        $tag = Tag::create($data);
        return response()->json($tag, 201);
    }

    public function update(Request $request, Tag $tag)
    {
        $data = $request->validate(['nom' => 'required|string|max:255']);
        $tag->update($data);
        return response()->json($tag);
    }

    public function destroy(Tag $tag)
    {
        $tag->delete();
        return response()->json(null, 204);
    }
}
