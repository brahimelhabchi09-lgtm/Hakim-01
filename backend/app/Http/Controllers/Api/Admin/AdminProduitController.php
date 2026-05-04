<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProduitRequest;
use App\Http\Resources\ProduitResource;
use App\Models\Produit;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminProduitController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = Produit::with(['category', 'marque'])->latest();

        if ($request->filled('search')) {
            $query->where('nom', 'like', "%{$request->search}%");
        }

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }


        return response()->json(ProduitResource::collection($query->paginate($request->get('per_page', 15))));
    }

    public function store(ProduitRequest $request): JsonResponse
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('produits', 'public');
        }

        if ($request->hasFile('images')) {
            $data['images'] = collect($request->file('images'))
                ->map(fn($file) => $file->store('produits/galerie', 'public'))
                ->toArray();
        }

        if ($request->filled('specifications')) {
            $data['specifications'] = json_decode($request->specifications, true);
        }

        $produit = Produit::create($data);

        if ($request->filled('tags')) {
            $produit->tags()->sync($request->tags);
        }

        return response()->json([
            'message' => 'Produit cree avec succes.',
            'produit' => ProduitResource::make($produit),
        ], 201);
    }

    public function show($id): JsonResponse
    {
        $produit = Produit::with(['category', 'marque', 'tags', 'allAvis.user'])->findOrFail($id);

        return response()->json([
            'produit' => ProduitResource::make($produit),
        ]);
    }

    public function update(ProduitRequest $request, $id): JsonResponse
    {
        $produit = Produit::findOrFail($id);
        $data = $request->validated();

        if ($request->hasFile('image')) {
            if ($produit->image) {
                \Storage::disk('public')->delete($produit->image);
            }
            $data['image'] = $request->file('image')->store('produits', 'public');
        }

        if ($request->hasFile('images')) {
            if ($produit->images) {
                foreach ($produit->images as $img) {
                    \Storage::disk('public')->delete($img);
                }
            }
            $data['images'] = collect($request->file('images'))
                ->map(fn($file) => $file->store('produits/galerie', 'public'))
                ->toArray();
        }

        if ($request->filled('specifications')) {
            $data['specifications'] = json_decode($request->specifications, true);
        }

        $produit->update($data);

        if ($request->filled('tags')) {
            $produit->tags()->sync($request->tags);
        }

        return response()->json([
            'message' => 'Produit modifie avec succes.',
            'produit' => ProduitResource::make($produit),
        ]);
    }

    public function destroy($id): JsonResponse
    {
        $produit = Produit::findOrFail($id);

        if ($produit->image) {
            \Storage::disk('public')->delete($produit->image);
        }

        if ($produit->images) {
            foreach ($produit->images as $img) {
                \Storage::disk('public')->delete($img);
            }
        }

        $produit->delete();

        return response()->json([
            'message' => 'Produit supprime.',
        ]);
    }
}
