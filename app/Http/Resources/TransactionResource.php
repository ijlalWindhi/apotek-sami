<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'customer_type' => $this->customer_type,
            'recipe' => new RecipeResource($this->whenLoaded('recipe')),
            'notes' => $this->notes,
            'payment_type' => new PaymentTypeResource($this->whenLoaded('paymentType')),
            'status' => $this->status,
            'invoice_number' => $this->invoice_number,
            'discount' => $this->discount,
            'discount_type' => $this->discount_type,
            'nominal_discount' => $this->nominal_discount,
            'paid_amount' => $this->paid_amount,
            'change_amount' => $this->change_amount,
            'total_amount' => $this->total_amount,
            'total_before_discount' => $this->total_before_discount,
            'created_by' => new UserResource($this->whenLoaded('createdBy')),
            'products' => ProductTransactionResource::collection($this->whenLoaded('productTransactions')),
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
            'deleted_at' => $this->deleted_at?->format('Y-m-d H:i:s')
        ];
    }
}
