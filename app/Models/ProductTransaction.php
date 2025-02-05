<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductTransaction extends Model
{
    use SoftDeletes;
    const DECIMAL_FORMAT = 'decimal:2';

    protected $table = 'm_product_transaction';

    protected $fillable = [
        'transaction_id',
        'product_id',
        'unit_id',
        'qty',
        'price',
        'tuslah',
        'discount',
        'nominal_discount',
        'discount_type',
        'subtotal',
    ];

    protected $casts = [
        'qty' => 'integer',
        'price' => self::DECIMAL_FORMAT,
        'tuslah' => self::DECIMAL_FORMAT,
        'discount' => self::DECIMAL_FORMAT,
        'subtotal' => self::DECIMAL_FORMAT
    ];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class, 'transaction_id');
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
