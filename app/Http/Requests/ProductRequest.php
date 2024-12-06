<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'status' => 'required|boolean',
            'sku' => 'required|string|unique:products,sku',
            'type' => 'required|in:obat,alkes,umum,jasa',
            'unit_id' => 'required|exists:units,id',
            'manufacturer' => 'required|string',
            'storage_location' => 'nullable|string',
            'notes' => 'nullable|string',
            'purchase_price' => 'required|numeric|min:0',
            'show_markup_margin' => 'required|boolean',
            'markup_percentage' => 'required_if:show_markup_margin,true|nullable|numeric',
            'margin_percentage' => 'required_if:show_markup_margin,true|nullable|numeric',
            'selling_price' => 'required|numeric|min:0|gt:purchase_price',
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
