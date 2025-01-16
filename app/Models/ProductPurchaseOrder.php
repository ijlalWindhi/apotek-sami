<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductPurchaseOrder extends Model
{
    use SoftDeletes;

    protected $table = 'm_product_purchase_order';

    protected $fillable = [
        'purchase_order_id',
        'product_id',
        'qty',
        'price',
        'discount',
        'discount_type',
        'subtotal',
        'description'
    ];

    protected $casts = [
        'qty' => 'integer',
        'price' => 'decimal:2',
        'discount' => 'decimal:2',
        'subtotal' => 'decimal:2'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function purchaseOrder()
    {
        return $this->belongsTo(PurchaseOrder::class);
    }
}
