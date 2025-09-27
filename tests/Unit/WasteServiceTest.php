<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Services\WasteService;
use App\Services\HouseholdService;
use App\Repositories\WasteRepository;
use App\Repositories\HouseholdRepository;
use App\Repositories\PaymentRepository;
use App\Models\Household;
use App\Models\Payment;

class WasteServiceTest extends TestCase
{
    protected WasteService $wasteService;
    protected HouseholdService $householdService;

    protected function setUp(): void
    {
        parent::setUp();

        $households = new HouseholdRepository();
        $payments   = new PaymentRepository();
        $this->householdService = new HouseholdService($households, $payments);
        $this->wasteService     = new WasteService(new WasteRepository(), $this->householdService);
    }

    /** @test */
    public function cannot_create_pickup_if_unpaid_payment_exists()
    {
        $household = Household::create([
            'owner_name' => 'Test User',
            'address' => 'Jl. Test 123',
        ]);

        Payment::create([
            'household_id' => $household->_id,
            'amount' => 50000,
            'status' => Payment::STATUS_PENDING,
        ]);

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("Household has unpaid payments. Cannot create pickup.");

        $this->wasteService->create([
            'household_id' => $household->_id,
            'type' => 'organic'
        ]);
    }
}
