<?php

use App\Http\Controllers\Api\{
    HouseholdController,
    WasteController,
    PaymentController,
    ReportController
};

use Illuminate\Support\Facades\Route;

Route::apiResource('households', HouseholdController::class);

Route::prefix('pickups')->group(function () {
    Route::get('/', [WasteController::class, 'index']);
    Route::post('/', [WasteController::class, 'store']);
    Route::put('{id}/schedule', [WasteController::class, 'schedule']);
    Route::put('{id}/complete', [WasteController::class, 'complete']);
    Route::put('{id}/cancel', [WasteController::class, 'cancel']);
});

Route::prefix('payments')->group(function () {
    Route::get('/', [PaymentController::class, 'index']);
    Route::post('/', [PaymentController::class, 'store']);
    Route::put('{id}/confirm', [PaymentController::class, 'confirm']);
});

Route::prefix('reports')->group(function () {
    Route::get('waste-summary', [ReportController::class, 'wasteSummary']);
    Route::get('payment-summary', [ReportController::class, 'paymentSummary']);
    Route::get('households/{id}/history', [ReportController::class, 'householdHistory']);
});
