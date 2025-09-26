<?php

namespace App\Services;

use App\Repositories\HouseholdRepository;
use App\Repositories\PaymentRepository;
use App\Models\Household;

class HouseholdService
{
    public function __construct(
        protected HouseholdRepository $households,
        protected PaymentRepository $payments
    ) {}

    public function create(array $data): Household
    {
        return $this->households->create($data);
    }

    public function getAll(array $filters = [], int $perPage = 10)
    {
        return $this->households->all($filters, $perPage);
    }

    public function getById(string $id): ?Household
    {
        return $this->households->find($id);
    }

    public function update(string $id, array $data): ?Household
    {
        $household = $this->households->find($id);
        return $household ? $this->households->update($household, $data) : null;
    }

    public function delete(string $id): bool
    {
        $household = $this->households->find($id);
        return $household ? $this->households->delete($household) : false;
    }

    public function canCreatePickup(string $householdId): bool
    {
        return !$this->payments->all([
            'household_id' => $householdId,
            'status'       => 'pending'
        ])->count();
    }
}
