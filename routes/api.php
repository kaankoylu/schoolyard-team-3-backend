<?php

use App\Http\Controllers\Api\DesignFeedController;
use App\Http\Controllers\Api\DesignCommentController;
use App\Http\Controllers\Api\DesignReactionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\DesignController;
use App\Http\Controllers\Api\AssetController;
use App\Http\Controllers\Api\ClassController;
use App\Http\Controllers\Api\ClassCodeController;
use App\Http\Controllers\Api\StudentSessionController;

/*
|--------------------------------------------------------------------------
| Health
|--------------------------------------------------------------------------
*/
Route::get('/ping', function () {
    return response()->json(['message' => 'pong']);
});

/*
|--------------------------------------------------------------------------
| Auth
|--------------------------------------------------------------------------
*/
Route::post('/login', [AuthenticatedSessionController::class, 'store']);
Route::post('/register', [RegisteredUserController::class, 'store']);
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth:sanctum');

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

/*
|--------------------------------------------------------------------------
| Classes / Student session
|--------------------------------------------------------------------------
*/
Route::get('/classes', [ClassController::class, 'index']);
Route::post('/classes', [ClassController::class, 'store']);
Route::delete('/classes/{class}', [ClassController::class, 'destroy']);
Route::post('/classes/{class}/code', [ClassCodeController::class, 'generate']);
    Route::get('/class-codes/resolve', [ClassCodeController::class, 'resolve']);

Route::post('/student-session', [StudentSessionController::class, 'create']);


/*
|--------------------------------------------------------------------------
| Designs (Laravel controllers)
|--------------------------------------------------------------------------
| Public for now (no Sanctum), same as your earlier setup.
*/
Route::get('/designs', [DesignController::class, 'index']);
Route::post('/designs', [DesignController::class, 'store']);
Route::get('/designs/{design}', [DesignController::class, 'show']);
Route::post('/designs/{id}/feedback', [DesignController::class, 'storeFeedback']);

// For grading
Route::post('/designs/{design}/grade', [DesignController::class, 'saveGrade']);

/*
|--------------------------------------------------------------------------
| Assets (Laravel controllers)
|--------------------------------------------------------------------------
*/
Route::get('/assets', [AssetController::class, 'index']);
Route::post('/assets', [AssetController::class, 'store']);
Route::get('/assets/{asset}', [AssetController::class, 'show']);
Route::patch('/assets/{asset}', [AssetController::class, 'update']);
Route::delete('/assets/{asset}', [AssetController::class, 'destroy']);


Route::get('/feed', [DesignFeedController::class, 'feed']);
Route::get('/leaderboard', [DesignFeedController::class, 'leaderboard']);

Route::get('/designs/{design}/comments', [DesignCommentController::class, 'index']);
Route::post('/designs/{design}/comments', [DesignCommentController::class, 'store']);

Route::post('/designs/{design}/react', [DesignReactionController::class, 'react']);
