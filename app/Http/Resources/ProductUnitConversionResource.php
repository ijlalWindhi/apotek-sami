<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductUnitConversionResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'from_unit' => new UnitResource($this->fromUnit),
            'to_unit' => new UnitResource($this->toUnit),
            'from_value' => $this->from_value,
            'to_value' => $this->to_value
        ];
    }
}
