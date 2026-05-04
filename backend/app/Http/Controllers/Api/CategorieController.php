<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\ProduitResource;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CategorieController extends Controller
{
    public function index(): JsonResponse
    {
        $categories = Category::with(['children'])
            ->whereNull('parent_id')
            ->withCount('produits')
            ->get();

        return response()->json([
            'categories' => CategoryResource::collection($categories),
        ]);
    }

    public function show(string $slug, Request $request): JsonResponse
    {
        $category = Category::where('slug', $slug)->first();

        if (!$category) {
            return response()->json([
                'message' => 'Categorie non trouvee.',
            ], 404);
        }

        $produits = Produit::with(['category', 'marque'])
            ->where('category_id', $category->id)
            ->latest()
            ->paginate($request->get('per_page', 12));

        return response()->json([
            'category' => CategoryResource::make($category),
            'produits' => ProduitResource::collection($produits),
        ]);
    }

    public function enfants(string $slug): JsonResponse
    {
        $category = Category::where('slug', $slug)->firstOrFail();

        $enfants = Category::withCount('produits')
            ->where('parent_id', $category->id)
            ->get();

        return response()->json([
            'enfants' => CategoryResource::collection($enfants),
        ]);
    }
}
