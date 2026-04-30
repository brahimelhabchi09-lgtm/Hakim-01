<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CategorieRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;

class AdminCategorieController extends Controller
{
    public function index(): JsonResponse
    {
        $categories = Category::with(['children', 'parent'])->withCount('produits')->get();

        return response()->json([
            'categories' => CategoryResource::collection($categories),
        ]);
    }

    public function store(CategorieRequest $request): JsonResponse
    {
        $data = $request->validated();
        $data['slug'] = Str::slug($data['nom']);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('categories', 'public');
        }

        $category = Category::create($data);

        return response()->json([
            'message' => 'Categorie creee avec succes.',
            'category' => CategoryResource::make($category),
        ], 201);
    }

    public function update(CategorieRequest $request, $id): JsonResponse
    {
        $category = Category::findOrFail($id);
        $data = $request->validated();

        if ($request->hasFile('image')) {
            if ($category->image) {
                \Storage::disk('public')->delete($category->image);
            }
            $data['image'] = $request->file('image')->store('categories', 'public');
        }

        if (isset($data['nom']) && !isset($data['slug'])) {
            $data['slug'] = Str::slug($data['nom']);
        }

        $category->update($data);

        return response()->json([
            'message' => 'Categorie modifiee avec succes.',
            'category' => CategoryResource::make($category),
        ]);
    }

    public function destroy($id): JsonResponse
    {
        $category = Category::findOrFail($id);

        if ($category->image) {
            \Storage::disk('public')->delete($category->image);
        }

        $category->delete();

        return response()->json([
            'message' => 'Categorie supprimee.',
        ]);
    }
}
