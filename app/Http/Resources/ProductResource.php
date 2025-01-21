<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    public function toArray($request): array
    {
        // Load relations if they haven't been loaded
        $this->load(['supplier', 'largestUnit', 'smallestUnit']);

        return [
            'id' => $this->id,
            'name' => $this->name,
            'type' => $this->type,
            'drug_group' => $this->drug_group,
            'sku' => $this->sku,
            'minimum_smallest_stock' => $this->minimum_smallest_stock,
            'smallest_stock' => $this->smallest_stock,
            'largest_stock' => $this->largest_stock,
            'supplier' => $this->whenLoaded('supplier', function () {
                return new SupplierResource($this->supplier);
            }),
            'is_active' => $this->is_active,
            'largest_unit' => $this->whenLoaded('largestUnit', function () {
                return new UnitResource($this->largestUnit);
            }),
            'smallest_unit' => $this->whenLoaded('smallestUnit', function () {
                return new UnitResource($this->smallestUnit);
            }),
            'conversion_value' => $this->conversion_value,
            'description' => $this->description,
            'purchase_price' => $this->purchase_price,
            'margin_percentage' => $this->margin_percentage,
            'selling_price' => $this->selling_price,
            'created_at' => $this->created_at?->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at?->format('Y-m-d H:i:s')
        ];
    }
}
