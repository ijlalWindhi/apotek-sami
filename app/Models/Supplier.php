<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Supplier extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'm_supplier';
    protected $fillable = [
        'type',
        'code',
        'name',
        'is_active',
        'payment_type',
        'payment_term',
        'description',
        'address',
        'postal_code',
        'phone_1',
        'phone_2',
        'email'
    ];
    protected $casts = [
        'is_active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime'
    ];

    public function paymentType()
    {
        return $this->belongsTo(PaymentType::class);
    }

    public function purchaseOrders()
    {
        return $this->hasMany(PurchaseOrder::class);
    }
}
