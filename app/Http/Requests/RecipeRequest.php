<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RecipeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    private const NUMERIC_MIN_ZERO = 'required|numeric|min:0';
    private const NUMERIC_MIN_ZERO_NULLABLE = 'nullable|numeric|min:0';

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:100',
            'status' => ['required', Rule::in(['Proses', 'Tunda'])],
            'staff_id' => 'required|exists:users,id',
            'customer_name' => 'required|string|max:100',
            'customer_age' => 'required|integer|min:0',
            'customer_address' => 'nullable|string',
            'doctor_name' => 'required|string|max:100',
            'doctor_sip' => 'nullable|string|max:100',

            // Validasi untuk products
            'products' => 'required|array|min:1',
            'products.*.product' => 'required|exists:m_product,id',
            'products.*.unit' => 'required|exists:m_unit,id',
            'products.*.qty' => 'required|integer|min:1',
            'products.*.price' => self::NUMERIC_MIN_ZERO,
            'products.*.tuslah' => self::NUMERIC_MIN_ZERO_NULLABLE,
            'products.*.discount' => self::NUMERIC_MIN_ZERO_NULLABLE,
            'products.*.discount_type' => ['required', Rule::in(['Percentage', 'Nominal'])],
            'products.*.subtotal' => self::NUMERIC_MIN_ZERO,
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nama resep wajib diisi.',
            'name.string' => 'Nama resep harus berupa teks.',
            'name.max' => 'Nama resep maksimal 100 karakter.',
            'status.required' => 'Status resep wajib dipilih.',
            'status.in' => 'Status resep tidak valid.',
            'staff_id.required' => 'Staff wajib dipilih.',
            'staff_id.exists' => 'Staff yang dipilih tidak valid.',
            'customer_name.required' => 'Nama pelanggan wajib diisi.',
            'customer_name.string' => 'Nama pelanggan harus berupa teks.',
            'customer_name.max' => 'Nama pelanggan maksimal 100 karakter.',
            'customer_age.required' => 'Umur pelanggan wajib diisi.',
            'customer_age.integer' => 'Umur pelanggan harus berupa angka.',
            'customer_age.min' => 'Umur pelanggan minimal 0.',
            'customer_address.string' => 'Alamat pelanggan harus berupa teks.',
            'doctor_name.required' => 'Nama dokter wajib diisi.',
            'doctor_name.string' => 'Nama dokter harus berupa teks.',
            'doctor_name.max' => 'Nama dokter maksimal 100 karakter.',
            'doctor_sip.string' => 'Nomor SIP dokter harus berupa teks.',
            'doctor_sip.max' => 'Nomor SIP dokter maksimal 100 karakter.',

            'products.required' => 'Minimal harus ada 1 produk.',
            'products.*.product.required' => 'Produk wajib dipilih.',
            'products.*.product.exists' => 'Produk yang dipilih tidak valid.',
            'products.*.unit.required' => 'Satuan wajib dipilih.',
            'products.*.unit.exists' => 'Satuan yang dipilih tidak valid.',
            'products.*.qty.required' => 'Quantity wajib diisi.',
            'products.*.qty.min' => 'Quantity minimal 1.',
            'products.*.price.required' => 'Harga wajib diisi.',
            'products.*.price.min' => 'Harga minimal 0.',
            'products.*.tuslah.min' => 'Tuslah minimal 0.',
            'products.*.discount.min' => 'Diskon minimal 0.',
            'products.*.discount_type.required' => 'Tipe diskon wajib dipilih.',
            'products.*.discount_type.in' => 'Tipe diskon tidak valid.',
            'products.*.description.string' => 'Deskripsi produk harus berupa teks.',
            'products.*.subtotal.min' => 'Subtotal minimal 0.',
            'products.*.subtotal.required' => 'Subtotal wajib diisi.',
            'products.*.subtotal.numeric' => 'Subtotal harus berupa angka.',
        ];
    }

    protected function prepareForValidation(): void
    {
        // Convert boolean string to actual boolean
        if ($this->has('payment_include_tax')) {
            $this->merge([
                'payment_include_tax' => $this->payment_include_tax === 'true' || $this->payment_include_tax === true,
            ]);
        }

        // Set default values if not provided
        $this->merge([
            'discount' => $this->discount ?? 0,
        ]);
    }
}
