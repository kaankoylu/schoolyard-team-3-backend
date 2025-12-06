<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\DesignController;
use App\Http\Controllers\Api\AssetController;
// ---- Simple connectivity test ----
Route::get('/ping', function () {
    return response()->json(['message' => 'pong']);
});

// ---- Authentication ----
Route::post('/login', [AuthenticatedSessionController::class, 'store']);

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth:sanctum');

// ---- Protected route that returns current user ----
Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

// ---- DESIGN API ----
//
// Public for now.
// Later you can add   ->middleware('auth:sanctum')
//
Route::post('/designs', [DesignController::class, 'store']);
Route::get('/designs/{design}', [DesignController::class, 'show']);
Route::get('/designs', [DesignController::class, 'index']);
Route::post('/designs/{id}/feedback', [DesignController::class, 'storeFeedback']);
Route::get('/assets', [AssetController::class, 'index']);
Route::post('/assets', [AssetController::class, 'store']); // file upload + save
Route::patch('/assets/{asset}', [AssetController::class, 'update']); // 🔹 toggle availability
