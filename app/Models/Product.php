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
        'status',
        'sku',
        'type',
        'unit_id',
        'category_id',
        'minimum_stock',
        'manufacturer',
        'notes',
        'purchase_price',
        'show_markup_margin',
        'markup_percentage',
        'margin_percentage',
    ];

    protected $casts = [
        'status' => 'boolean',
        'show_markup_margin' => 'boolean',
        'purchase_price' => self::DECIMAL_CAST,
        'markup_percentage' => self::DECIMAL_CAST,
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
}
