<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Household extends Model
{
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

    public function wastes()
    {
        return $this->hasMany(Waste::class, 'household_id');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class, 'household_id');
    }
}
