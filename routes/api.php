<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\VendorItemController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\Auth\AuthController;
// Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::middleware(['auth:api', 'throttle:100,1'])->group(function () {

    Route::apiResource('orders', OrderController::class);
    Route::apiResource('vendors', VendorController::class);
    Route::apiResource('vendor-items', VendorItemController::class);
    Route::apiResource('items', ItemController::class);
    Route::get('reports/item-vendor', [ReportController::class, 'getItemVendorReport']);
    Route::get('reports/most-transacted', [ReportController::class, 'getMostTransactedReport']);
    Route::get('reports/rate-report', [ReportController::class, 'getRateReport']);

    Route::post('updateAkun/{user}', [AuthController::class, 'updateAkun']);

});

Route::middleware('throttle:60,1')->group(function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);

});