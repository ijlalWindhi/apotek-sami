<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ReturnResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'return_number' => $this->return_number,
            'transaction' => new TransactionResource($this->whenLoaded('transaction')),
            'return_reason' => $this->return_reason,
            'qty_total' => $this->qty_total,
            'total_before_discount' => $this->total_before_discount,
            'total_return' => $this->total_return,
            'created_by' => new UserResource($this->whenLoaded('createdBy')),
            'product_returns' => ProductReturnResource::collection($this->whenLoaded('productReturns')),
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
            'deleted_at' => $this->deleted_at?->format('Y-m-d H:i:s')
        ];
    }
}
