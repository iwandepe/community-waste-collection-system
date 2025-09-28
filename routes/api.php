<?php

use App\Http\Controllers\Api\{
    AuthController,
    HouseholdController,
    WasteController,
    PaymentController,
    ReportController
};

use Illuminate\Support\Facades\Route;

Route::post('auth/login', [AuthController::class, 'login']);
Route::middleware(['auth:api'])->group(function () {
    Route::get('auth//profile', [AuthController::class, 'me']);
    Route::post('auth//logout', [AuthController::class, 'logout']);
    Route::post('auth//refresh', [AuthController::class, 'refresh']);

    Route::put('pickups/{id}/complete', [WasteController::class, 'complete']);
    Route::put('payments/{id}/confirm', [PaymentController::class, 'confirm']);
});

Route::apiResource('households', HouseholdController::class);

Route::prefix('pickups')->group(function () {
    Route::get('/', [WasteController::class, 'index']);
    Route::post('/', [WasteController::class, 'store']);
    Route::put('{id}/schedule', [WasteController::class, 'schedule']);
    Route::put('{id}/cancel', [WasteController::class, 'cancel']);
});

Route::prefix('payments')->group(function () {
    Route::get('/', [PaymentController::class, 'index']);
    Route::post('/', [PaymentController::class, 'store']);
});

Route::prefix('reports')->group(function () {
    Route::get('waste-summary', [ReportController::class, 'wasteSummary']);
    Route::get('payment-summary', [ReportController::class, 'paymentSummary']);
    Route::get('households/{id}/history', [ReportController::class, 'householdHistory']);
});