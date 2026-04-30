<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AvisResource;
use App\Http\Resources\ProduitResource;
use App\Models\Avis;
use App\Models\Produit;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProduitController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = Produit::with(['category', 'marque', 'tags'])
            ->where('en_vedette', true);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nom', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        if ($request->filled('origin')) {
            $query->where('pays_origine', $request->origin);
        }

        if ($request->filled('marque')) {
            $query->whereHas('marque', function ($q) use ($request) {
                $q->where('slug', $request->marque);
            });
        }

        if ($request->filled('tags')) {
            $tags = explode(',', $request->tags);
            $query->where(function ($q) use ($tags) {
                foreach ($tags as $tag) {
                    $q->orWhereJsonContains('tags', $tag);
                }
            });
        }

        if ($request->filled('price_min')) {
            $query->where('prix', '>=', $request->price_min);
        }

        if ($request->filled('price_max')) {
            $query->where('prix', '<=', $request->price_max);
        }

        $sort = $request->get('sort', 'created_at');
        $direction = $request->get('direction', 'desc');

        $allowedSorts = ['prix', 'avis_moyenne', 'nom', 'created_at'];
        if (in_array($sort, $allowedSorts)) {
            $query->orderBy($sort, $direction);
        }

        $produits = $query->paginate($request->get('per_page', 12));

        return response()->json(ProduitResource::collection($produits)->additional([
            'filters' => [
                'categories' => \App\Models\Category::withCount('produits')->get(),
                'origins' => \App\Models\Origin::all(),
                'marques' => \App\Models\Marque::withCount('produits')->get(),
                'tags' => ['sans-gluten', 'fromage', 'snack', 'energisant', 'boisson-gazeuse', 'guarana', 'taurine', 'cafeine', 'churros', 'chocolat', 'patisserie', 'nougat', 'amandes', 'traditionnel', 'sans-sucre', 'tropical', 'gele', 'oursons', 'noir', '70-cacao', 'acai', 'superfood', 'antioxydants', 'biscuits', 'vanille', 'chips', 'sale', 'glace', 'premium', 'the-vert', 'japon', 'ramen', 'epice', 'kimchi', 'coree', 'fermente', 'creme', 'caramel', 'noisettes', 'pate-tartiner', 'coca', 'classique', 'bubble-tea', 'the', 'tapioca', 'fromage', 'surprise', 'mystere', 'box', 'unknown', 'generique', 'beurre', 'economie', 'sans-marque', 'economique', 'varie', 'aleatoire', 'mix'],
            ],
        ]));
    }

    public function enVedette(): JsonResponse
    {
        $produits = Produit::with(['category', 'marque', 'tags'])
            ->where('actif', true)
            ->where('en_vedette', true)
            ->limit(8)
            ->get();

        return response()->json([
            'produits' => ProduitResource::collection($produits),
        ]);
    }

    public function show(string $slug): JsonResponse
    {
        $produit = Produit::with(['category', 'marque', 'tags', 'avis' => function ($query) {
            $query->latest()->limit(10);
        }])->where('slug', $slug)->where('actif', true)->first();

        if (!$produit) {
            return response()->json([
                'message' => 'Produit non trouve.',
            ], 404);
        }

        return response()->json([
            'produit' => ProduitResource::make($produit),
        ]);
    }

    public function avis($id, Request $request): JsonResponse
    {
        $produit = Produit::where('actif', true)->findOrFail($id);

        $avis = $produit->avis()->with('user')->latest()->paginate($request->get('per_page', 10));

        return response()->json(AvisResource::collection($avis));
    }

    public function ajouterAvis(Request $request, $id): JsonResponse
    {
        $user = $request->user();

        $request->validate([
            'note' => 'required|integer|min:1|max:5',
            'titre' => 'nullable|string|max:255',
            'contenu' => 'nullable|string|max:2000',
        ]);

        $existing = Avis::where('user_id', $user->id)->where('produit_id', $id)->first();
        if ($existing) {
            return response()->json([
                'message' => 'Vous avez deja laisse un avis pour ce produit.',
            ], 400);
        }

        $avis = Avis::create([
            'user_id' => $user->id,
            'produit_id' => $id,
            'note' => $request->note,
            'titre' => $request->titre,
            'contenu' => $request->contenu,
            'statut' => 'en_attente',
        ]);

        return response()->json([
            'message' => 'Avis soumis avec succes. Il sera visible apres approbation.',
            'avis' => AvisResource::make($avis),
        ], 201);
    }

    public function apparentes($id): JsonResponse
    {
        $produit = Produit::findOrFail($id);

        $apparentes = Produit::with(['category', 'marque'])
            ->where('actif', true)
            ->where('id', '!=', $id)
            ->where('category_id', $produit->category_id)
            ->limit(4)
            ->get();

        if ($apparentes->count() < 4) {
            $remaining = 4 - $apparentes->count();
            $more = Produit::with(['category', 'marque'])
                ->where('actif', true)
                ->whereNotIn('id', $apparentes->pluck('id')->merge([$id]))
                ->limit($remaining)
                ->get();
            $apparentes = $apparentes->merge($more);
        }

        return response()->json([
            'produits' => ProduitResource::collection($apparentes),
        ]);
    }
}
