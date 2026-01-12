<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ClassCode;
use App\Models\SchoolClass;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ClassCodeController extends Controller
{
    public function generate(Request $request, SchoolClass $class)
    {
        $validated = $request->validate([
            'expires_in_minutes' => 'nullable|integer|min:5|max:10080',
        ]);

        // Only one active code per class
        ClassCode::where('class_id', $class->id)->delete();

        do {
            $code = strtoupper(Str::random(6));
        } while (ClassCode::where('code', $code)->exists());

        $expiresAt = !empty($validated['expires_in_minutes'])
            ? now()->addMinutes((int) $validated['expires_in_minutes'])
            : null;

        $row = ClassCode::create([
            'class_id' => $class->id,
            'code' => $code,
            'expires_at' => $expiresAt,
        ]);

        return response()->json($row, 201);
    }

    // ✅ NEW: resolve class by code (used by student login)
    public function resolve(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|min:1|max:64'
        ]);

        $code = strtoupper(trim($validated['code']));

        $row = ClassCode::where('code', $code)->first();

        if (!$row) {
            return response()->json(['message' => 'Invalid code.'], 404);
        }

        // expired?
        if ($row->expires_at && now()->greaterThan($row->expires_at)) {
            return response()->json(['message' => 'Code expired.'], 410);
        }

        return response()->json([
            'class_id' => $row->class_id,
            'expires_at' => $row->expires_at,
        ]);
    }
}
