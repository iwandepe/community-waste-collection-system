<?php

namespace App\Services;

use App\Repositories\WasteRepository;
use App\Repositories\HouseholdRepository;
use App\Models\Waste;
use App\Models\WasteElectronic;
use App\Models\WasteOrganic;
use Exception;

class WasteService
{
    public function __construct(
        protected WasteRepository $wastes,
        protected HouseholdService $households
    ) {}

    public function create(array $data): Waste
    {
        if (!$this->households->canCreatePickup($data['household_id'])) {
            throw new Exception("Household has unpaid payments. Cannot create pickup.");
        }
        
        $data['status'] = Waste::STATUS_PENDING;

        return $this->wastes->create($data);
    }

    public function getAll(array $filters = [], int $perPage = 10)
    {
        return $this->wastes->all($filters, $perPage);
    }

    public function schedule(string $id, \DateTime $date): Waste
    {
        $waste = $this->wastes->find($id);
        if (!$waste) throw new Exception("Pickup not found.");

        if ($waste instanceof WasteElectronic && !$waste->safety_check) {
            throw new Exception("Electronic waste requires safety check before scheduling.");
        }

        $waste->schedule($date);
        return $waste;
    }

    public function complete(string $id): Waste
    {
        $waste = $this->wastes->find($id);
        if (!$waste) throw new Exception("Pickup not found.");

        $waste->complete();
        return $waste;
    }

    public function cancel(string $id): Waste
    {
        $waste = $this->wastes->find($id);
        if (!$waste) throw new Exception("Pickup not found.");

        $waste->cancel();
        return $waste;
    }

    public function autoCancelOrganic()
    {
        $organics = WasteOrganic::where('status', Waste::STATUS_PENDING)->get();
        foreach ($organics as $waste) {
            $waste->checkExpiration();
        }
    }
}
