<?php

use Illuminate\Support\Facades\Route;

// ---- Web routes go here ----
// If you want a homepage:
Route::get('/', function () {
    return view('welcome');
});

// Breeze auth routes (keep if Breeze installed)
require __DIR__.'/auth.php';

// NOTE:
// DO NOT put any /api/... routes here
// All API requests must go into routes/api.php
