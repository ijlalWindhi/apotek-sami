<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PurchaseOrderResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'code' => $this->code,
            'supplier' => new SupplierResource($this->whenLoaded('supplier')),
            'order_date' => $this->order_date->format('d-m-Y'),
            'delivery_date' => $this->delivery_date?->format('d-m-Y'),
            'payment_due_date' => $this->payment_due_date->format('d-m-Y'),
            'tax' => new TaxResource($this->whenLoaded('tax')),
            'no_factur_supplier' => $this->no_factur_supplier,
            'description' => $this->description,
            'payment_type' => new PaymentTypeResource($this->whenLoaded('paymentType')),
            'payment_term' => $this->payment_term,
            'payment_status' => $this->payment_status,
            'payment_include_tax' => $this->payment_include_tax,
            'qty_total' => $this->qty_total,
            'discount' => $this->discount,
            'discount_type' => $this->discount_type,
            'nominal_discount' => $this->nominal_discount,
            'total_before_tax_discount' => $this->total_before_tax_discount,
            'tax_total' => $this->tax_total,
            'discount_total' => $this->discount_total,
            'total' => $this->total,
            'products' => ProductPurchaseOrderResource::collection($this->whenLoaded('productPurchaseOrders')),
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
            'deleted_at' => $this->deleted_at?->format('Y-m-d H:i:s')
        ];
    }
}
