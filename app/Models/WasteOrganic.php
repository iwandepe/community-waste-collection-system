<?php

namespace App\Models;

class WasteOrganic extends Waste
{
    protected $attributes = [
        'type' => 'organic',
    ];

    public function checkExpiration()
    {
        if ($this->status === self::STATUS_PENDING && $this->created_at->diffInDays(now()) > 3) {
            $this->cancel();
        }
    }
}