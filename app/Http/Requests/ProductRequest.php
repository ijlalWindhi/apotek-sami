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
            'minimum_stock' => 'required|integer|min:0',
            'stock' => 'nullable|integer',
            'supplier_id' => 'required|exists:m_supplier,id',
            'is_active' => 'required|boolean',
            'unit_id' => 'required|exists:m_unit,id',
            'description' => 'nullable|string',
            'purchase_price' => self::NUMERIC_MIN_ZERO,
            'show_margin' => 'boolean',
            'margin_percentage' => 'required_if:show_markup_margin,true|nullable|numeric',
            'selling_price' => 'required|numeric|min:0|gt:purchase_price',
            'unit_conversions' => 'nullable|array',
            'unit_conversions.*.from_unit_id' => 'required|exists:m_unit,id',
            'unit_conversions.*.to_unit_id' => 'required|exists:m_unit,id',
            'unit_conversions.*.from_value' => self::NUMERIC_MIN_ZERO,
            'unit_conversions.*.to_value' => self::NUMERIC_MIN_ZERO,
        ];
    }

    public function messages(): array
    {
        return [
            'type.in' => 'The selected type is invalid.',
            'drug_group.in' => 'The selected drug group is invalid.',
            'sku.unique' => 'The sku has already been taken.',
            'supplier.exists' => 'The selected supplier is invalid.',
            'unit.exists' => 'The selected unit is invalid.',
            'purchase_price.min' => 'The purchase price must be at least 0.',
            'show_margin.boolean' => 'The show margin must be true or false.',
            'margin_percentage.required_if' => 'The margin percentage field is required when show margin is true.',
            'margin_percentage.numeric' => 'The margin percentage must be a number.',
            'selling_price.min' => 'The selling price must be at least 0.',
            'selling_price.gt' => 'The selling price must be greater than the purchase price.',
            'unit_conversions.*.from_unit_id.required' => 'The from unit is required',
            'unit_conversions.*.to_unit_id.required' => 'The to unit is required',
            'unit_conversions.*.from_value.required' => 'The from value is required',
            'unit_conversions.*.to_value.required' => 'The to value is required',
        ];
    }
}
