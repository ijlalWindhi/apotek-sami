<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'status' => $this->status,
            'sku' => $this->sku,
            'type' => $this->type,
            'unit' => $this->unit,
            'manufacturer' => $this->manufacturer,
            'storage_location' => $this->storage_location,
            'notes' => $this->notes,
            'purchase_price' => $this->purchase_price,
            'show_markup_margin' => $this->show_markup_margin,
            'markup_percentage' => $this->markup_percentage,
            'margin_percentage' => $this->margin_percentage,
            'selling_price' => $this->selling_price,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s')
        ];
    }
}
