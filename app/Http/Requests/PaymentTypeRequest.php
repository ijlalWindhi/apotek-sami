<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PaymentTypeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'account_bank' => 'nullable|string|max:255',
            'name_bank' => 'nullable|string|max:255',
            'is_active' => 'required|boolean'
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nama pembayaran harus diisi',
            'name.string' => 'Nama pembayaran harus berupa teks',
            'name.max' => 'Nama pembayaran maksimal 255 karakter',
            'description.string' => 'Deskripsi harus berupa teks',
            'description.max' => 'Deskripsi maksimal 1000 karakter',
            'account_bank.string' => 'Nomor rekening harus berupa teks',
            'account_bank.max' => 'Nomor rekening maksimal 255 karakter',
            'name_bank.string' => 'Nama bank harus berupa teks',
            'name_bank.max' => 'Nama bank maksimal 255 karakter',
        ];
    }
}
