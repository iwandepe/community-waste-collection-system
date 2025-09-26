<?php

namespace App\Services;

use App\Repositories\ReportRepository;

class ReportService
{
    public function __construct(protected ReportRepository $reports) {}

    public function wasteSummary()
    {
        return $this->reports->wasteSummary();
    }

    public function paymentSummary()
    {
        return $this->reports->paymentSummary();
    }

    public function householdHistory(string $householdId)
    {
        return $this->reports->householdHistory($householdId);
    }
}
