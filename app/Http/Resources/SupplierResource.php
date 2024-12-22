<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SupplierResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'type' => $this->type,
            'code' => $this->code,
            'name' => $this->name,
            'is_active' => $this->is_active,
            'payment_type' => $this->payment_type,
            'payment_term' => $this->payment_term,
            'description' => $this->description,
            'address' => $this->address,
            'postal_code' => $this->postal_code,
            'phone_1' => $this->phone_1,
            'phone_2' => $this->phone_2,
            'email' => $this->email,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s')
        ];
    }
}
