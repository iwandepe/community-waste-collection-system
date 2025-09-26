<?php

namespace App\Models;

class WasteElectronic extends Waste
{
    protected $attributes = [
        'type' => 'electronic',
    ];

    public function schedule(\DateTime $date)
    {
        if (!$this->safety_check) {
            throw new \Exception("Electronic waste requires safety check before scheduling.");
        }
        parent::schedule($date);
    }
}
