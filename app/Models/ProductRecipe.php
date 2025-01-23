<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductRecipe extends Model
{
    use SoftDeletes;

    protected $table = 'm_product_recipe';

    protected $fillable = [
        'recipe_id',
        'product_id',
        'unit_id',
        'qty',
        'price',
        'tuslah',
        'discount',
        'discount_type',
        'subtotal',
    ];

    protected $casts = [
        'qty' => 'integer',
        'price' => 'decimal:2',
        'tuslah' => 'decimal:2',
        'discount' => 'decimal:2',
        'subtotal' => 'decimal:2'
    ];

    public function recipe()
    {
        return $this->belongsTo(Recipe::class, 'recipe_id');
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
