<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductUnitConversion extends Model
{
    use SoftDeletes;

    protected $table = 'm_product_unit_conversion';

    protected $fillable = [
        'product_id',
        'from_unit_id',
        'to_unit_id',
        'from_value',
        'to_value'
    ];

    protected $casts = [
        'from_value' => 'decimal:2',
        'to_value' => 'decimal:2'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function fromUnit()
    {
        return $this->belongsTo(Unit::class, 'from_unit_id');
    }

    public function toUnit()
    {
        return $this->belongsTo(Unit::class, 'to_unit_id');
    }
}
