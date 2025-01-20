<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    private const DECIMAL_CAST = 'decimal:2';

    protected $table = 'm_product';
    protected $fillable = [
        'name',
        'type',
        'drug_group',
        'sku',
        'minimum_stock',
        'stock',
        'is_active',
        'supplier_id',
        'largest_unit',
        'smallest_unit',
        'conversion_value',
        'description',
        'purchase_price',
        'selling_price',
        'margin_percentage',
    ];

    protected $casts = [
        'purchase_price' => self::DECIMAL_CAST,
        'margin_percentage' => self::DECIMAL_CAST,
        'selling_price' => self::DECIMAL_CAST,
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime'
    ];

    public function largestUnit(): BelongsTo
    {
        return $this->belongsTo(Unit::class, 'largest_unit');
    }

    public function smallestUnit(): BelongsTo
    {
        return $this->belongsTo(Unit::class, 'smallest_unit');
    }


    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }
}
