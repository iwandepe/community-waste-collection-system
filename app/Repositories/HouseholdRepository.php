<?php

namespace App\Repositories;

use App\Models\Household;

class HouseholdRepository
{
    public function create(array $data): Household
    {
        return Household::create($data);
    }

    public function find(string $id): ?Household
    {
        return Household::find($id);
    }

    public function all(array $filters = [], int $perPage = 10)
    {
        $query = Household::query();

        if (!empty($filters['block'])) {
            $query->where('block', $filters['block']);
        }

        if (!empty($filters['no'])) {
            $query->where('no', $filters['no']);
        }

        if (!empty($filters['search'])) {
            $query->where('owner_name', 'like', "%{$filters['search']}%");
        }

        return $query->paginate($perPage);
    }

    public function update(Household $household, array $data): Household
    {
        $household->update($data);
        return $household;
    }

    public function delete(Household $household): bool
    {
        return $household->delete();
    }
}
