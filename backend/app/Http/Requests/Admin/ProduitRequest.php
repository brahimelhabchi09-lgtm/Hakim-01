<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ProduitRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('id');

        return [
            'nom' => 'required|string|max:255',
            'slug' => 'nullable|unique:produits,slug,' . $id,
            'description' => 'nullable|string',
            'prix' => 'required|numeric|min:0',
            'prix_promotionnel' => 'nullable|numeric|min:0|lt:prix',
            'stock' => 'required|integer|min:0',
            'image_principale' => 'nullable|image|max:2048',
            'images_galerie.*' => 'nullable|image|max:2048',
            'specifications' => 'nullable|json',
            'actif' => 'boolean',
            'en_vedette' => 'boolean',
            'category_id' => 'nullable|exists:categories,id',
            'marque_id' => 'nullable|exists:marques,id',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
        ];
    }
}
