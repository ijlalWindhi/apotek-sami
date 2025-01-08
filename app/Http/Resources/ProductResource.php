<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    public function toArray($request): array
    {
        // Load relations if they haven't been loaded
        $this->load(['supplier', 'unit']);

        return [
            'id' => $this->id,
            'name' => $this->name,
            'type' => $this->type,
            'drug_group' => $this->drug_group,
            'sku' => $this->sku,
            'minimum_stock' => $this->minimum_stock,
            'stock' => $this->stock,
            'supplier' => $this->whenLoaded('supplier', function () {
                return new SupplierResource($this->supplier);
            }),
            'is_active' => $this->is_active,
            'unit' => $this->whenLoaded('unit', function () {
                return new UnitResource($this->unit);
            }),
            'description' => $this->description,
            'purchase_price' => $this->purchase_price,
            'show_margin' => $this->show_margin,
            'margin_percentage' => $this->margin_percentage,
            'selling_price' => $this->selling_price,
            'unit_conversions' => ProductUnitConversionResource::collection($this->whenLoaded('unitConversions')),
            'created_at' => $this->created_at?->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at?->format('Y-m-d H:i:s')
        ];
    }
}
