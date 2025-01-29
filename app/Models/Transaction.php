<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use SoftDeletes;
    const DECIMAL_FORMAT = 'decimal:2';

    protected $table = 'm_transaction';

    protected $fillable = [
        'customer_type',
        'recipe_id',
        'notes',
        'payment_type_id',
        'status',
        'invoice_number',
        'discount',
        'discount_type',
        'paid_amount',
        'change_amount',
        'total_amount',
        'created_by'
    ];

    protected $casts = [
        'discount' => self::DECIMAL_FORMAT,
        'discount_type' => 'string',
        'paid_amount' => self::DECIMAL_FORMAT,
        'change_amount' => self::DECIMAL_FORMAT,
        'total_amount' => self::DECIMAL_FORMAT
    ];

    public function paymentType()
    {
        return $this->belongsTo(PaymentType::class);
    }

    public function recipe()
    {
        return $this->belongsTo(Recipe::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function productTransactions()
    {
        return $this->hasMany(ProductTransaction::class);
    }
}
