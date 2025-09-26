<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\WasteRequest;
use App\Http\Resources\WasteResource;
use App\Services\WasteService;
use Illuminate\Http\Request;

class WasteController extends Controller
{
    public function __construct(protected WasteService $wastes) {}

    public function index(Request $request)
    {
        $filters = $request->only(['status', 'type', 'household_id']);
        $data = $this->wastes->getAll($filters, $request->get('per_page', 10));

        return WasteResource::collection($data);
    }

    public function store(WasteRequest $request)
    {
        $waste = $this->wastes->create($request->validated());

        return new WasteResource($waste);
    }

    public function schedule(Request $request, string $id)
    {
        $waste = $this->wastes->schedule($id, new \DateTime($request->get('pickup_date')));
        return new WasteResource($waste);
    }

    public function complete(string $id)
    {
        $waste = $this->wastes->complete($id);
        return new WasteResource($waste);
    }

    public function cancel(string $id)
    {
        $waste = $this->wastes->cancel($id);
        return new WasteResource($waste);
    }
}
