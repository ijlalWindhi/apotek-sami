<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tax extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'm_tax';
    protected $fillable = ['name', 'rate', 'description'];
    protected $casts = [
        'rate' => 'float',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime'
    ];

    // Mutator
    public function setRateAttribute($value)
    {
        $this->attributes['rate'] = str_replace(',', '.', $value);
    }
}
