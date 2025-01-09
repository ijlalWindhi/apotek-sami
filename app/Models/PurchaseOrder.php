<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PurchaseOrder extends Model
{
    use SoftDeletes;

    protected $table = 'm_purchase_order';

    protected $fillable = [
        'code',
        'supplier',
        'order_date',
        'delivery_date',
        'payment_due_date',
        'tax',
        'no_factur_supplier',
        'description',
        'payment_type',
        'payment_term',
        'payment_include_tax',
        'qty_total',
        'discount',
        'discount_type',
        'total_before_tax_discount',
        'tax_total',
        'discount_total',
        'total'
    ];

    protected $casts = [
        'order_date' => 'date',
        'delivery_date' => 'date',
        'payment_due_date' => 'date',
        'payment_include_tax' => 'boolean',
        'qty_total' => 'integer',
        'discount' => 'decimal:2',
        'discount_type' => 'string',
        'total_before_tax_discount' => 'decimal:2',
        'tax_total' => 'decimal:2',
        'discount_total' => 'decimal:2',
        'total' => 'decimal:2'
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function tax()
    {
        return $this->belongsTo(Tax::class);
    }

    public function paymentType()
    {
        return $this->belongsTo(PaymentType::class, "payment_type", "id");
    }

    public function productPurchaseOrders()
    {
        return $this->hasMany(ProductPurchaseOrder::class);
    }
}
