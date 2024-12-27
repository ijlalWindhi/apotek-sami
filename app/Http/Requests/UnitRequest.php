<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UnitRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'symbol' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000'
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nama pajak harus diisi',
            'rate.required' => 'Besaran pajak harus diisi',
            'rate.numeric' => 'Besaran pajak harus berupa angka',
            'rate.min' => 'Besaran pajak minimal 0',
            'rate.max' => 'Besaran pajak maksimal 100'
        ];
    }
}
