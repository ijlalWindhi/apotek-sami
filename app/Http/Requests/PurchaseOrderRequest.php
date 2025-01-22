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
            'supplier_id' => 'required|exists:m_supplier,id',
            'order_date' => 'required|date',
            'delivery_date' => 'nullable|date|after_or_equal:order_date',
            'payment_due_date' => 'required|date|after_or_equal:order_date',
            'tax_id' => 'required|exists:m_tax,id',
            'no_factur_supplier' => 'nullable|string|max:100',
            'description' => 'nullable|string',
            'payment_type_id' => 'required|exists:m_payment_type,id',
            'payment_term' => ['required', Rule::in(['Tunai', '1 Hari', '7 Hari', '14 Hari', '21 Hari', '30 Hari', '45 Hari'])],
            'payment_include_tax' => 'boolean',
            'qty_total' => 'required|integer|min:0',
            'discount' => self::NUMERIC_MIN_ZERO_NULLABLE,
            'discount_type' => ['required', Rule::in(['Percentage', 'Nominal'])],
            'nominal_discount' => self::NUMERIC_MIN_ZERO,
            'total_before_tax_discount' => self::NUMERIC_MIN_ZERO,
            'tax_total' => self::NUMERIC_MIN_ZERO,
            'discount_total' => self::NUMERIC_MIN_ZERO,
            'total' => self::NUMERIC_MIN_ZERO,

            // Validasi untuk products
            'products' => 'required|array|min:1',
            'products.*.product' => 'required|exists:m_product,id',
            'products.*.unit' => 'required|exists:m_unit,id',
            'products.*.qty' => 'required|integer|min:1',
            'products.*.price' => self::NUMERIC_MIN_ZERO,
            'products.*.discount' => self::NUMERIC_MIN_ZERO_NULLABLE,
            'products.*.discount_type' => ['required', Rule::in(['Percentage', 'Nominal'])],
            'products.*.subtotal' => self::NUMERIC_MIN_ZERO,
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
            'tax.exists' => 'Pajak yang dipilih tidak valid.',
            'payment_type.exists' => 'Tipe pembayaran yang dipilih tidak valid.',
            'payment_term.in' => 'Termin pembayaran yang dipilih tidak valid.',
            'payment_include_tax.boolean' => 'Payment include tax harus berupa true atau false.',
            'qty_total.required' => 'Total quantity wajib diisi.',
            'qty_total.integer' => 'Total quantity harus berupa angka.',
            'qty_total.min' => 'Total quantity minimal 0.',
            'discount.min' => 'Diskon minimal 0.',
            'total_before_tax_discount.min' => 'Total sebelum diskon pajak minimal 0.',
            'total_before_tax_discount.required' => 'Total sebelum diskon pajak wajib diisi.',
            'total_before_tax_discount.numeric' => 'Total sebelum diskon pajak harus berupa angka.',
            'tax_total.min' => 'Total pajak minimal 0.',
            'tax_total.required' => 'Total pajak wajib diisi.',
            'tax_total.numeric' => 'Total pajak harus berupa angka.',
            'discount_total.min' => 'Total diskon minimal 0.',
            'discount_total.required' => 'Total diskon wajib diisi.',
            'discount_total.numeric' => 'Total diskon harus berupa angka.',
            'total.min' => 'Total minimal 0.',
            'total.required' => 'Total wajib diisi.',
            'total.numeric' => 'Total harus berupa angka.',

            'products.required' => 'Minimal harus ada 1 produk.',
            'products.*.product.required' => 'Produk wajib dipilih.',
            'products.*.product.exists' => 'Produk yang dipilih tidak valid.',
            'products.*.unit.required' => 'Satuan wajib dipilih.',
            'products.*.unit.exists' => 'Satuan yang dipilih tidak valid.',
            'products.*.qty.required' => 'Quantity wajib diisi.',
            'products.*.qty.min' => 'Quantity minimal 1.',
            'products.*.price.required' => 'Harga wajib diisi.',
            'products.*.price.min' => 'Harga minimal 0.',
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
