<?php

namespace App\Repositories;

use App\Models\Waste;
use App\Models\Payment;

class ReportRepository
{
    public function wasteSummary()
    {
        return Waste::raw(function($collection) {
            return $collection->aggregate([
                ['$group' => [
                    '_id'   => ['type' => '$type', 'status' => '$status'],
                    'count' => ['$sum' => 1],
                ]]
            ]);
        });
    }

    public function paymentSummary()
    {
        return Payment::raw(function($collection) {
            return $collection->aggregate([
                ['$group' => [
                    '_id'    => '$status',
                    'total'  => ['$sum' => '$amount'],
                    'count'  => ['$sum' => 1],
                ]]
            ]);
        });
    }

    public function householdHistory(string $householdId)
    {
        return [
            'pickups'  => Waste::where('household_id', $householdId)->get(),
            'payments' => Payment::where('household_id', $householdId)->get(),
        ];
    }
}
