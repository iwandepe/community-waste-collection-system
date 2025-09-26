<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\HouseholdRequest;
use App\Http\Resources\HouseholdResource;
use App\Services\HouseholdService;
use Illuminate\Http\Request;

class HouseholdController extends Controller
{
    public function __construct(protected HouseholdService $households) {}

    public function index(Request $request)
    {
        $filters = $request->only(['search', 'block', 'no']);
        $data = $this->households->getAll($filters, $request->get('per_page', 10));

        return HouseholdResource::collection($data);
    }

    public function store(HouseholdRequest $request)
    {
        $household = $this->households->create($request->validated());

        return new HouseholdResource($household);
    }

    public function show(string $id)
    {
        $household = $this->households->getById($id);

        return $household ? new HouseholdResource($household) : response()->json(['message' => 'Not found'], 404);
    }

    public function update(HouseholdRequest $request, string $id)
    {
        $household = $this->households->update($id, $request->validated());

        return $household ? new HouseholdResource($household) : response()->json(['message' => 'Not found'], 404);
    }

    public function destroy(string $id)
    {
        return $this->households->delete($id)
            ? response()->json(['message' => 'Deleted'])
            : response()->json(['message' => 'Not found'], 404);
    }
}
