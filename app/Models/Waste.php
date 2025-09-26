<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Waste extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'wastes';

    protected $fillable = [
        'household_id',
        'pickup_date',
        'status',
        'type', // discriminator field: organic, plastic, paper, electronic
        'safety_check',
    ];

    protected $casts = [
        'pickup_date' => 'datetime',
        'created_at'  => 'datetime',
        'updated_at'  => 'datetime',
    ];

    const STATUS_PENDING   = 'pending';
    const STATUS_SCHEDULED = 'scheduled';
    const STATUS_COMPLETED = 'completed';
    const STATUS_CANCELED  = 'canceled';

    public function household()
    {
        return $this->belongsTo(Household::class, 'household_id');
    }

    public function schedule(\DateTime $date)
    {
        if ($this->status !== self::STATUS_PENDING) {
            throw new \Exception("Only pending pickups can be scheduled.");
        }
        $this->pickup_date = $date;
        $this->status = self::STATUS_SCHEDULED;
        $this->save();
    }

    public function complete()
    {
        if ($this->status !== self::STATUS_SCHEDULED) {
            throw new \Exception("Only scheduled pickups can be completed.");
        }
        $this->status = self::STATUS_COMPLETED;
        $this->save();

        $this->generatePayment();
    }

    protected function generatePayment()
    {
        $amount = match ($this->type) {
            'organic', 'plastic', 'paper' => 50000,
            'electronic'                  => 100000,
            default                       => 0,
        };

        Payment::create([
            'household_id' => $this->household_id,
            'amount'       => $amount,
            'status'       => Payment::STATUS_PENDING,
        ]);
    }

    public function cancel()
    {
        $this->status = self::STATUS_CANCELED;
        $this->save();
    }
}
