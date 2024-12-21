<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CustomerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'phone_number' => 'nullable|string|max:16',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string|max:255',
            'birth_date' => 'nullable|date',
            'notes' => 'nullable|string|max:1000',
            'gender' => [
                'required',
                Rule::in(['man', 'woman'])
            ]
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nama dokter harus diisi',
            'phone_number.max' => 'Nomor telepon maksimal 16 karakter',
            'email.email' => 'Format email tidak valid',
            'email.max' => 'Email maksimal 255 karakter',
            'address.max' => 'Alamat maksimal 255 karakter',
            'sip_number.max' => 'Nomor SIP maksimal 255 karakter',
            'notes.max' => 'Catatan maksimal 1000 karakter'
        ];
    }
}
