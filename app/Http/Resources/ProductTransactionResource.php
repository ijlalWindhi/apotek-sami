<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductTransactionResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'transaction_id' => $this->transaction_id,
            'product' => new ProductResource($this->whenLoaded('product')),
            'unit' => new UnitResource($this->whenLoaded('unit')),
            'qty' => $this->qty,
            'price' => $this->price,
            'tuslah' => $this->tuslah,
            'discount' => $this->discount,
            'discount_type' => $this->discount_type,
            'subtotal' => $this->subtotal,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
            'deleted_at' => $this->deleted_at?->format('Y-m-d H:i:s')
        ];
    }
}
