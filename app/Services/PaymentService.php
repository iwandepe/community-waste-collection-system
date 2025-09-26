<?php

namespace App\Services;

use App\Repositories\PaymentRepository;
use App\Models\Payment;
use Exception;

class PaymentService
{
    public function __construct(protected PaymentRepository $payments) {}

    public function create(array $data): Payment
    {
        return $this->payments->create($data);
    }

    public function getAll(array $filters = [], int $perPage = 10)
    {
        return $this->payments->all($filters, $perPage);
    }

    public function confirm(string $id): Payment
    {
        $payment = $this->payments->find($id);
        if (!$payment) throw new Exception("Payment not found.");

        return $this->payments->confirm($payment);
    }
}
