<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReturnRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    private const NUMERIC_MIN_ZERO = 'required|numeric|min:0';

    public function rules(): array
    {
        return [
            'transaction_id' => 'required|exists:m_transaction,id',
            'return_reason' => 'nullable|string',
            'qty_total' => self::NUMERIC_MIN_ZERO,
            'total_before_discount' => self::NUMERIC_MIN_ZERO,
            'total_return' => self::NUMERIC_MIN_ZERO,
            'created_by' => 'required|exists:users,id',

            // Validasi untuk products yang direturn
            'products' => 'required|array|min:1',
            'products.*.product_transaction_id' => 'required|exists:m_product_transaction,id',
            'products.*.product_id' => 'required|exists:m_product,id',
            'products.*.unit_id' => 'required|exists:m_unit,id',
            'products.*.qty_return' => 'required|integer|min:1',
            'products.*.subtotal_return' => self::NUMERIC_MIN_ZERO,
        ];
    }

    public function messages(): array
    {
        return [
            'transaction_id.required' => 'Transaksi wajib dipilih.',
            'transaction_id.exists' => 'Transaksi yang dipilih tidak valid.',
            'return_reason.string' => 'Alasan return harus berupa teks.',
            'qty_total.required' => 'Total quantity wajib diisi.',
            'qty_total.numeric' => 'Total quantity harus berupa angka.',
            'qty_total.min' => 'Total quantity minimal 0.',
            'total_before_discount.required' => 'Total sebelum diskon wajib diisi.',
            'total_before_discount.numeric' => 'Total sebelum diskon harus berupa angka.',
            'total_before_discount.min' => 'Total sebelum diskon minimal 0.',
            'total_return.required' => 'Total return wajib diisi.',
            'total_return.numeric' => 'Total return harus berupa angka.',
            'total_return.min' => 'Total return minimal 0.',
            'created_by.required' => 'Staff wajib dipilih.',
            'created_by.exists' => 'Staff yang dipilih tidak valid.',

            'products.required' => 'Minimal harus ada 1 produk yang direturn.',
            'products.array' => 'Format produk tidak valid.',
            'products.min' => 'Minimal harus ada 1 produk yang direturn.',
            'products.*.product_transaction_id.required' => 'Transaksi produk wajib dipilih.',
            'products.*.product_transaction_id.exists' => 'Transaksi produk yang dipilih tidak valid.',
            'products.*.product_id.required' => 'Produk wajib dipilih.',
            'products.*.product_id.exists' => 'Produk yang dipilih tidak valid.',
            'products.*.unit_id.required' => 'Satuan wajib dipilih.',
            'products.*.unit_id.exists' => 'Satuan yang dipilih tidak valid.',
            'products.*.qty_return.required' => 'Quantity return wajib diisi.',
            'products.*.qty_return.integer' => 'Quantity return harus berupa angka bulat.',
            'products.*.qty_return.min' => 'Quantity return minimal 1.',
            'products.*.subtotal_return.required' => 'Subtotal return wajib diisi.',
            'products.*.subtotal_return.numeric' => 'Subtotal return harus berupa angka.',
            'products.*.subtotal_return.min' => 'Subtotal return minimal 0.',
        ];
    }

    protected function prepareForValidation(): void
    {
        // Set default values if not provided
        $this->merge([
            'qty_total' => $this->qty_total ?? 0,
            'total_before_discount' => $this->total_before_discount ?? 0,
            'total_return' => $this->total_return ?? 0,
        ]);
    }
}
