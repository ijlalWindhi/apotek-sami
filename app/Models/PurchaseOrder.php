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
        'status',
        'tax',
        'no_factur_supplier',
        'description',
        'payment_type',
        'payment_term',
        'payment_include_tax',
        'payment_total',
        'qty_total',
        'discount',
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
        'payment_total' => 'decimal:2',
        'qty_total' => 'integer',
        'discount' => 'decimal:2',
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
        return $this->belongsTo(PaymentType::class);
    }

    public function productPurchaseOrders()
    {
        return $this->hasMany(ProductPurchaseOrder::class);
    }
}
