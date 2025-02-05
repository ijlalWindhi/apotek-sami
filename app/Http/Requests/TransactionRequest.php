<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TransactionRequest extends FormRequest
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
            'customer_type' => ['required', Rule::in(['Umum', 'Rutin', 'Karyawan'])],
            'recipe_id' => 'nullable|exists:m_recipe,id',
            'notes' => 'nullable|string',
            'payment_type_id' => 'required|exists:m_payment_type,id',
            'status' => ['required', Rule::in(['Terbayar', 'Proses', 'Tertunda'])],
            'discount' => self::NUMERIC_MIN_ZERO_NULLABLE,
            'discount_type' => ['required', Rule::in(['Percentage', 'Nominal'])],
            'nominal_discount' => self::NUMERIC_MIN_ZERO,
            'paid_amount' => self::NUMERIC_MIN_ZERO,
            'change_amount' => self::NUMERIC_MIN_ZERO,
            'total_amount' => self::NUMERIC_MIN_ZERO,
            'total_before_discount' => self::NUMERIC_MIN_ZERO,
            'created_by' => 'required|exists:users,id',

            // Validasi untuk products
            'products' => 'required|array|min:1',
            'products.*.id' => 'nullable|exists:m_product_transaction,id',
            'products.*.product' => 'required|exists:m_product,id',
            'products.*.unit' => 'required|exists:m_unit,id',
            'products.*.qty' => 'required|integer|min:1',
            'products.*.price' => self::NUMERIC_MIN_ZERO,
            'products.*.tuslah' => self::NUMERIC_MIN_ZERO_NULLABLE,
            'products.*.discount' => self::NUMERIC_MIN_ZERO_NULLABLE,
            'products.*.nominal_discount' => self::NUMERIC_MIN_ZERO_NULLABLE,
            'products.*.discount_type' => ['required', Rule::in(['Percentage', 'Nominal'])],
            'products.*.subtotal' => self::NUMERIC_MIN_ZERO,
        ];
    }

    public function messages(): array
    {
        return [
            'customer_type.required' => 'Tipe pelanggan wajib dipilih.',
            'customer_type.in' => 'Tipe pelanggan tidak valid.',
            'recipe_id.exists' => 'Resep yang dipilih tidak valid.',
            'payment_type_id.required' => 'Tipe pembayaran wajib dipilih.',
            'payment_type_id.exists' => 'Tipe pembayaran yang dipilih tidak valid.',
            'status.required' => 'Status wajib dipilih.',
            'status.in' => 'Status tidak valid.',
            'invoice_number.required' => 'Nomor invoice wajib diisi.',
            'invoice_number.string' => 'Nomor invoice harus berupa teks.',
            'invoice_number.max' => 'Nomor invoice maksimal 50 karakter.',
            'invoice_number.unique' => 'Nomor invoice sudah digunakan.',
            'discount.min' => 'Diskon minimal 0.',
            'discount_type.required' => 'Tipe diskon wajib dipilih.',
            'discount_type.in' => 'Tipe diskon tidak valid.',
            'nominal_discount.required' => 'Nominal diskon wajib diisi.',
            'nominal_discount.numeric' => 'Nominal diskon harus berupa angka.',
            'nominal_discount.min' => 'Nominal diskon minimal 0.',
            'paid_amount.required' => 'Jumlah yang dibayar wajib diisi.',
            'paid_amount.numeric' => 'Jumlah yang dibayar harus berupa angka.',
            'paid_amount.min' => 'Jumlah yang dibayar minimal 0.',
            'change_amount.required' => 'Jumlah kembalian wajib diisi.',
            'change_amount.numeric' => 'Jumlah kembalian harus berupa angka.',
            'change_amount.min' => 'Jumlah kembalian minimal 0.',
            'total_amount.required' => 'Total wajib diisi.',
            'total_amount.numeric' => 'Total harus berupa angka.',
            'total_amount.min' => 'Total minimal 0.',
            'total_before_discount.required' => 'Total sebelum diskon wajib diisi.',
            'total_before_discount.numeric' => 'Total sebelum diskon harus berupa angka.',
            'total_before_discount.min' => 'Total sebelum diskon minimal 0.',
            'created_by.required' => 'Staff wajib dipilih.',
            'created_by.exists' => 'Staff yang dipilih tidak valid.',

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
        // Set default values if not provided
        $this->merge([
            'discount' => $this->discount ?? 0,
        ]);
    }
}
