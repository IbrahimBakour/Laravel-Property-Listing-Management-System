<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PropertyController;
use App\Http\Controllers\Api\LocationController;

Route::name('api.')->group(function () {
    Route::middleware('auth')->get('/user', function (Request $request) {
        return $request->user();
    })->name('user');

    // Public read-only endpoints
    Route::apiResource('properties', PropertyController::class)->only(['index', 'show'])->names('api.properties');
    Route::apiResource('locations', LocationController::class)->only(['index', 'show'])->names('api.locations');

    // Authenticated endpoints (session-based auth)
    Route::middleware('auth')->group(function () {
        Route::apiResource('properties', PropertyController::class)->only(['store', 'update', 'destroy'])->names('api.properties');
        Route::apiResource('locations', LocationController::class)->only(['store', 'update', 'destroy'])->names('api.locations');
    });
});
