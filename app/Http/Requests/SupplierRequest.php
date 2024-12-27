<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SupplierRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'type' => 'required|in:Pedagang Besar Farmasi,Apotek Lain,Toko Obat,Lain-Lain',
            'is_active' => 'required|boolean',
            'payment_type' => 'required|exists:m_payment_type,id',
            'payment_term' => 'required|in:Tunai,1 Hari,7 Hari,14 Hari,21 Hari,30 Hari,45 Hari',
            'description' => 'nullable|string',
            'address' => 'nullable|string',
            'postal_code' => 'nullable|string|max:10',
            'phone_1' => 'nullable|string|max:50',
            'phone_2' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:100',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nama dokter harus diisi',
            'type.in' => 'Tipe supplier tidak valid',
            'code.required' => 'Kode supplier harus diisi',
            'code.unique' => 'Kode supplier sudah digunakan',
            'is_active.required' => 'Status aktif harus diisi',
            'is_active.boolean' => 'Status aktif harus berupa angka',
            'payment_type.required' => 'Tipe pembayaran harus diisi',
            'payment_type.exists' => 'Tipe pembayaran tidak valid',
            'payment_term.required' => 'Jangka waktu pembayaran harus diisi',
            'payment_term.in' => 'Jangka waktu pembayaran tidak valid',
            'description.string' => 'Deskripsi harus berupa teks',
            'address.string' => 'Alamat harus berupa teks',
            'postal_code.string' => 'Kode pos harus berupa teks',
            'postal_code.max' => 'Kode pos maksimal 10 karakter',
            'phone_1.string' => 'Nomor telepon 1 harus berupa teks',
            'phone_1.max' => 'Nomor telepon 1 maksimal 50 karakter',
            'phone_2.string' => 'Nomor telepon 2 harus berupa teks',
            'phone_2.max' => 'Nomor telepon 2 maksimal 50 karakter',
            'email.email' => 'Format email tidak valid',
        ];
    }
}
