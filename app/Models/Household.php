<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use MongoDB\Laravel\Eloquent\Model;

class Household extends Model
{
    use SoftDeletes;
    
    protected $connection = 'mongodb';
    protected $collection = 'households';

    protected $fillable = [
        'owner_name',
        'address',
        'block',
        'no',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected $dates = ['deleted_at'];

    public function wastes()
    {
        return $this->hasMany(Waste::class, 'household_id');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class, 'household_id');
    }
}
