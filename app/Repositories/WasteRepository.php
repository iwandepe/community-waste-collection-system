<?php

namespace App\Repositories;

use App\Models\Waste;

class WasteRepository
{
    public function create(array $data): Waste
    {
        return Waste::create($data);
    }

    public function find(string $id): ?Waste
    {
        return Waste::find($id);
    }

    public function all(array $filters = [], int $perPage = 10)
    {
        $query = Waste::query();

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (!empty($filters['type'])) {
            $query->where('type', $filters['type']);
        }

        if (!empty($filters['household_id'])) {
            $query->where('household_id', $filters['household_id']);
        }

        return $query->paginate($perPage);
    }

    public function update(Waste $waste, array $data): Waste
    {
        $waste->update($data);
        return $waste;
    }
}
