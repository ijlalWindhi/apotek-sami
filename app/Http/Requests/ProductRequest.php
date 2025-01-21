<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    private const NUMERIC_MIN_ZERO = 'required|numeric|min:0';

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'type' => 'required|in:Obat,Alat Kesehatan,Umum,Lain-Lain',
            'drug_group' => 'in:Obat Bebas,Obat Bebas Terbatas,Obat Keras,Obat Golongan Narkotika,Obat Fitofarmaka,Obat Herbal Terstandar (OHT),Obat Herbal (Jamu)',
            'sku' => [
                'required',
                'string',
                'max:255',
                Rule::unique('m_product')->ignore($this->route('product')),
            ],
            'minimum_smallest_stock' => 'required|integer|min:0',
            'smallest_stock' => 'nullable|integer',
            'largest_stock' => 'nullable|integer',
            'supplier_id' => 'required|exists:m_supplier,id',
            'is_active' => 'required|boolean',
            'largest_unit' => 'required|exists:m_unit,id',
            'smallest_unit' => 'required|exists:m_unit,id',
            'conversion_value' => 'required|integer|min:1',
            'description' => 'nullable|string',
            'purchase_price' => self::NUMERIC_MIN_ZERO,
            'selling_price' => 'required|numeric|min:0|gt:purchase_price',
            'margin_percentage' => 'required_if:show_markup_margin,true|nullable|numeric',
        ];
    }

    public function messages(): array
    {
        return [
            'type.in' => 'The selected type is invalid.',
            'drug_group.in' => 'The selected drug group is invalid.',
            'sku.unique' => 'The sku has already been taken.',
            'supplier.exists' => 'The selected supplier is invalid.',
            'is_active.boolean' => 'The is active must be true or false.',
            'largest_unit.exists' => 'The selected largest unit is invalid.',
            'smallest_unit.exists' => 'The selected smallest unit is invalid.',
            'conversion_value.min' => 'The conversion value must be at least 1.',
            'purchase_price.min' => 'The purchase price must be at least 0.',
            'margin_percentage.numeric' => 'The margin percentage must be a number.',
            'selling_price.min' => 'The selling price must be at least 0.',
            'selling_price.gt' => 'The selling price must be greater than the purchase price.',
        ];
    }
}
