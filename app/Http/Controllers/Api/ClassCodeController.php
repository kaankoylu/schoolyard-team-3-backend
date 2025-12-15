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
}
