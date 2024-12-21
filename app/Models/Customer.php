<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Customer extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'm_customer';
    protected $fillable = [
        'name',
        'phone_number',
        'email',
        'address',
        'birth_date',
        'notes',
        'gender'
    ];
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime'
    ];

    // Mutator
    public function setBirthDateAttribute($value)
    {
        $this->attributes['birth_date'] = Carbon::createFromFormat('d-m-Y', $value)->format('Y-m-d');
    }
}
