<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\MarqueRequest;
use App\Http\Resources\MarqueResource;
use App\Models\Marque;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;

class AdminMarqueController extends Controller
{
    public function index(): JsonResponse
    {
        $marques = Marque::withCount('produits')->latest()->get();

        return response()->json([
            'marques' => MarqueResource::collection($marques),
        ]);
    }

    public function store(MarqueRequest $request): JsonResponse
    {
        $data = $request->validated();
        $data['slug'] = Str::slug($data['nom']);

        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('marques', 'public');
        }

        $marque = Marque::create($data);

        return response()->json([
            'message' => 'Marque creee avec succes.',
            'marque' => MarqueResource::make($marque),
        ], 201);
    }

    public function update(MarqueRequest $request, $id): JsonResponse
    {
        $marque = Marque::findOrFail($id);
        $data = $request->validated();

        if ($request->hasFile('logo')) {
            if ($marque->logo) {
                \Storage::disk('public')->delete($marque->logo);
            }
            $data['logo'] = $request->file('logo')->store('marques', 'public');
        }

        if (isset($data['nom']) && !isset($data['slug'])) {
            $data['slug'] = Str::slug($data['nom']);
        }

        $marque->update($data);

        return response()->json([
            'message' => 'Marque modifiee avec succes.',
            'marque' => MarqueResource::make($marque),
        ]);
    }

    public function destroy($id): JsonResponse
    {
        $marque = Marque::findOrFail($id);

        if ($marque->logo) {
            \Storage::disk('public')->delete($marque->logo);
        }

        $marque->delete();

        return response()->json([
            'message' => 'Marque supprimee.',
        ]);
    }
}
