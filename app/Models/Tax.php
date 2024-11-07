<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tax extends Model
{
    use HasFactory;

    protected $table = 'm_tax';
    protected $fillable = ['name', 'rate', 'description'];

    // Mutator
    public function setRateAttribute($value)
    {
        $this->attributes['rate'] = str_replace(',', '.', $value);
    }
}
