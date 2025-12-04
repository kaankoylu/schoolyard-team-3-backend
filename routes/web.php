<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;


Route::get('/', function () {
    return ['Laravel' => app()->version()];
});

require __DIR__.'/auth.php';

// Route::post('/login', function (Request $request) {
//     $credentials = $request->only('email', 'password');

//     if (Auth::attempt($credentials)) {
//         $request->session()->regenerate();
//         return response()->json([
//             'message' => 'Login successful',
//             'user' => Auth::user(),
//         ]);
//     }

//     return response()->json(['message' => 'Login failed'], 401);
// });
//PUTTING THIS ONE TEMPRORY NON FUNCTIONAL.

// Temporary "bypass login"
Route::post('/login', function (Request $request) {
    $role = $request->input('role');

    $urls = [
        'teacher' => 'http://localhost:5174/dashboard/teacher',
        'student' => 'http://localhost:5174/dashboard/student',
        'admin'   => 'http://localhost:5174/dashboard/admin',
    ];

    if (!isset($urls[$role])) {
        return response()->json(['error' => 'Invalid role'], 400);
    }

    return response()->json(['redirect' => $urls[$role]]);
});

Route::get('/dashboard/teacher', function () {
    return "Teacher Dashboard";
});

Route::get('/dashboard/student', function () {
    return "Student Dashboard";
});

Route::get('/dashboard/admin', function () {
    return "Admin Dashboard";
});
