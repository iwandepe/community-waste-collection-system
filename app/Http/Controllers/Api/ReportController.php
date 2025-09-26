<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\ReportService;

class ReportController extends Controller
{
    public function __construct(protected ReportService $reports) {}

    public function wasteSummary()
    {
        return response()->json($this->reports->wasteSummary());
    }

    public function paymentSummary()
    {
        return response()->json($this->reports->paymentSummary());
    }

    public function householdHistory(string $id)
    {
        return response()->json($this->reports->householdHistory($id));
    }
}
