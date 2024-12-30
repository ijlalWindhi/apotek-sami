<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PurchaseOrderRequest extends FormRequest
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
            'code' => [
                'required',
                'string',
                'max:50',
                Rule::unique('m_purchase_order')->ignore($this->route('purchase_order')),
            ],
            'supplier' => 'required|exists:m_supplier,id',
            'order_date' => 'required|date',
            'delivery_date' => 'nullable|date|after_or_equal:order_date',
            'payment_due_date' => 'required|date|after_or_equal:order_date',
            'status' => ['required', Rule::in(['Draft', 'Ordered', 'Received', 'Canceled'])],
            'tax' => 'required|exists:m_tax,id',
            'no_factur_supplier' => 'nullable|string|max:100',
            'description' => 'nullable|string',
            'payment_type' => 'required|exists:m_payment_type,id',
            'payment_term' => ['required', Rule::in(['Tunai', '1 Hari', '7 Hari', '14 Hari', '21 Hari', '30 Hari', '45 Hari'])],
            'payment_include_tax' => 'boolean',
            'payment_total' => self::NUMERIC_MIN_ZERO,
            'discount' => self::NUMERIC_MIN_ZERO_NULLABLE,

            // Validasi untuk products
            'products' => 'required|array|min:1',
            'products.*.product' => 'required|exists:m_product,id',
            'products.*.qty' => 'required|integer|min:1',
            'products.*.price' => self::NUMERIC_MIN_ZERO,
            'products.*.discount' => self::NUMERIC_MIN_ZERO_NULLABLE,
            'products.*.discount_type' => ['required', Rule::in(['Percentage', 'Nominal'])],
            'products.*.tax' => self::NUMERIC_MIN_ZERO_NULLABLE,
            'products.*.description' => 'nullable|string',
        ];
    }

    public function messages(): array
    {
        return [
            'code.unique' => 'Kode purchase order sudah digunakan.',
            'supplier.exists' => 'Supplier yang dipilih tidak valid.',
            'order_date.required' => 'Tanggal order wajib diisi.',
            'delivery_date.after_or_equal' => 'Tanggal pengiriman harus sama dengan atau setelah tanggal order.',
            'payment_due_date.required' => 'Tanggal jatuh tempo pembayaran wajib diisi.',
            'payment_due_date.after_or_equal' => 'Tanggal jatuh tempo harus sama dengan atau setelah tanggal order.',
            'status.in' => 'Status yang dipilih tidak valid.',
            'tax.exists' => 'Pajak yang dipilih tidak valid.',
            'payment_type.exists' => 'Tipe pembayaran yang dipilih tidak valid.',
            'payment_term.in' => 'Termin pembayaran yang dipilih tidak valid.',
            'payment_include_tax.boolean' => 'Payment include tax harus berupa true atau false.',
            'payment_total.min' => 'Total pembayaran minimal 0.',
            'discount.min' => 'Diskon minimal 0.',

            'products.required' => 'Minimal harus ada 1 produk.',
            'products.*.product.required' => 'Produk wajib dipilih.',
            'products.*.product.exists' => 'Produk yang dipilih tidak valid.',
            'products.*.qty.required' => 'Quantity wajib diisi.',
            'products.*.qty.min' => 'Quantity minimal 1.',
            'products.*.price.required' => 'Harga wajib diisi.',
            'products.*.price.min' => 'Harga minimal 0.',
            'products.*.discount.min' => 'Diskon minimal 0.',
            'products.*.discount_type.required' => 'Tipe diskon wajib dipilih.',
            'products.*.discount_type.in' => 'Tipe diskon tidak valid.',
            'products.*.tax.min' => 'Pajak minimal 0.',
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
            'status' => $this->status ?? 'Draft',
            'discount' => $this->discount ?? 0,
        ]);
    }
}