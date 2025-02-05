<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Retur extends Model
{
    use SoftDeletes;

    protected $table = 'm_return';

    protected $fillable = [
        'return_number',
        'transaction_id',
        'return_reason',
        'qty_total',
        'total_before_discount',
        'total_return',
        'created_by',
    ];

    protected $casts = [
        'total_before_discount' => 'decimal:2',
        'total_return' => 'decimal:2',
        'qty_total' => 'integer'
    ];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class, 'transaction_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function productReturns()
    {
        return $this->hasMany(ProductReturn::class, 'return_id');
    }
}
