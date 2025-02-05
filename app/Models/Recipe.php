<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Recipe extends Model
{
    use SoftDeletes;

    protected $table = 'm_recipe';

    protected $fillable = [
        'name',
        'staff_id',
        'customer_name',
        'customer_age',
        'customer_address',
        'doctor_name',
        'doctor_sip',
    ];

    public function staff()
    {
        return $this->belongsTo(User::class, 'staff_id');
    }

    public function productRecipes()
    {
        return $this->hasMany(ProductRecipe::class, 'recipe_id');
    }
}
