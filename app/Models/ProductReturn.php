<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductReturn extends Model
{
    use SoftDeletes;

    protected $table = 'm_product_return';

    protected $fillable = [
        'return_id',
        'product_transaction_id',
        'product_id',
        'unit_id',
        'qty_return',
        'subtotal_return',
    ];

    protected $casts = [
        'qty_return' => 'integer',
        'subtotal_return' => 'decimal:2',
    ];

    public function retur()
    {
        return $this->belongsTo(Retur::class, 'return_id');
    }

    public function productTransaction()
    {
        return $this->belongsTo(ProductTransaction::class, 'product_transaction_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class, 'unit_id');
    }
}
