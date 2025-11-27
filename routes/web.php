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
