<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class MarqueRequest extends FormRequest
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
            'slug' => 'nullable|unique:marques,slug,' . $id,
            'logo' => 'nullable|image|max:2048',
            'pays_origine' => 'nullable|string|max:100',
            'description' => 'nullable|string',
        ];
    }
}
