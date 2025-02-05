<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RecipeResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'staff' => new UserResource($this->whenLoaded('staff')),
            'customer_name' => $this->customer_name,
            'customer_age' => $this->customer_age,
            'customer_address' => $this->customer_address,
            'doctor_name' => $this->doctor_name,
            'doctor_sip' => $this->doctor_sip,
            'products' => ProductRecipeResource::collection($this->whenLoaded('productRecipes')),
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
            'deleted_at' => $this->deleted_at?->format('Y-m-d H:i:s')
        ];
    }
}
