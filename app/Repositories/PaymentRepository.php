<?php

namespace App\Repositories;

use App\Models\Payment;

class PaymentRepository
{
    public function create(array $data): Payment
    {
        return Payment::create($data);
    }

    public function find(string $id): ?Payment
    {
        return Payment::find($id);
    }

    public function all(array $filters = [], int $perPage = 10)
    {
        $query = Payment::query();

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (!empty($filters['household_id'])) {
            $query->where('household_id', $filters['household_id']);
        }

        if (!empty($filters['date_from']) && !empty($filters['date_to'])) {
            $query->whereBetween('payment_date', [$filters['date_from'], $filters['date_to']]);
        }

        return $query->paginate($perPage);
    }

    public function confirm(Payment $payment): Payment
    {
        $payment->update([
            'status'       => Payment::STATUS_PAID,
            'payment_date' => now(),
        ]);
        return $payment;
    }
}
