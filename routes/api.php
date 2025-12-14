<?php
use App\Http\Controllers\Auth\RegisteredUserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\DesignController;
use App\Http\Controllers\Api\AssetController;
use App\Http\Controllers\Api\ClassController;
use App\Http\Controllers\Api\ClassCodeController;
use App\Http\Controllers\Api\StudentSessionController;

// ---- Simple connectivity test ----
Route::get('/ping', function () {
    return response()->json(['message' => 'pong']);
});

// ---- Authentication ----
Route::post('/login', [AuthenticatedSessionController::class, 'store']);
Route::post('/register', [RegisteredUserController::class, 'store']);
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth:sanctum');


// ---- CLASSES + CODES (TEMP PUBLIC, NO SANCTUM) ----
Route::get('/classes', [ClassController::class, 'index']);
Route::post('/classes', [ClassController::class, 'store']);
Route::delete('/classes/{class}', [ClassController::class, 'destroy']);

// generate a code for a class
Route::post('/classes/{class}/code', [ClassCodeController::class, 'generate']);


// ---- STUDENT "LOGIN" (PUBLIC) ----
Route::post('/student-session', [StudentSessionController::class, 'create']);



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



// ASSET CRUD
Route::get('/assets', [AssetController::class, 'index']);
Route::post('/assets', [AssetController::class, 'store']);
Route::get('/assets/{asset}', [AssetController::class, 'show']);
Route::patch('/assets/{asset}', [AssetController::class, 'update']);
Route::delete('/assets/{asset}', [AssetController::class, 'destroy']);
