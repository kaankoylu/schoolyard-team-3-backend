<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ClassCode;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class StudentSessionController extends Controller
{
    public function create(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:16',
            'student_name' => 'required|string|max:255',
        ]);

        $code = strtoupper(trim($validated['code']));

        $codeRow = ClassCode::where('code', $code)
            ->where(function ($q) {
                $q->whereNull('expires_at')->orWhere('expires_at', '>', now());
            })
            ->first();

        if (!$codeRow) {
            return response()->json(['message' => 'Invalid or expired code'], 422);
        }

        // ✅ every "login" gets a fresh unique id
        $sessionId = (string) Str::uuid();

        return response()->json([
            'class_id' => $codeRow->class_id,
            'student_name' => trim($validated['student_name']),
            'session_id' => $sessionId,
            'code' => $code, // optional, handy for debugging
        ]);
    }
}
