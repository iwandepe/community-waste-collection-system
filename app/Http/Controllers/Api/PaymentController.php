<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PaymentRequest;
use App\Http\Resources\PaymentResource;
use App\Services\PaymentService;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function __construct(protected PaymentService $payments) {}

    public function index(Request $request)
    {
        $filters = $request->only(['status', 'household_id', 'date_from', 'date_to']);
        $data = $this->payments->getAll($filters, $request->get('per_page', 10));

        return PaymentResource::collection($data);
    }

    public function store(PaymentRequest $request)
    {
        $payment = $this->payments->create($request->validated());

        return new PaymentResource($payment);
    }

    public function confirm(string $id)
    {
        $payment = $this->payments->confirm($id);
        return new PaymentResource($payment);
    }
}
