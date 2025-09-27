<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Household;

class HouseholdApiTest extends TestCase
{
    /** @test */
    public function can_create_a_household()
    {
        $response = $this->postJson('/api/households', [
            'owner_name' => 'John Doe',
            'address'    => 'Jl. Merdeka 123',
            'block'      => 'A',
            'no'         => '12',
        ]);

        $response->assertStatus(201)
                 ->assertJsonStructure([
                     'data' => ['id', 'owner_name', 'address', 'block', 'no', 'created_at']
                 ]);

        $this->assertDatabaseHas('households', ['owner_name' => 'John Doe']);
    }

    /** @test */
    public function cannot_create_household_without_owner_name()
    {
        $response = $this->postJson('/api/households', [
            'address' => 'Jl. Merdeka 123'
        ]);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['owner_name']);
    }
}
