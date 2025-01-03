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
        'supplier',
        'is_active',
        'unit',
        'description',
        'purchase_price',
        'show_margin',
        'margin_percentage',
        'selling_price'
    ];

    protected $casts = [
        'status' => 'boolean',
        'show_margin' => 'boolean',
        'purchase_price' => self::DECIMAL_CAST,
        'margin_percentage' => self::DECIMAL_CAST,
        'selling_price' => self::DECIMAL_CAST,
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime'
    ];

    public function unit(): BelongsTo
    {
        return $this->belongsTo(Unit::class);
    }

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }

    public function unitConversions()
    {
        return $this->hasMany(ProductUnitConversion::class);
    }
}
