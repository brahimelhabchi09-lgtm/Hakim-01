<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CategorieRequest extends FormRequest
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
            'slug' => 'nullable|unique:categories,slug,' . $id,
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'parent_id' => 'nullable|exists:categories,id',
        ];
    }
}
