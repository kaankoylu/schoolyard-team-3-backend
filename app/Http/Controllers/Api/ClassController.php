<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SchoolClass;
use Illuminate\Http\Request;

class ClassController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $classes = SchoolClass::where('teacher_id', $user->id)
            ->with(['activeCode'])
            ->orderBy('name')
            ->get();

        return response()->json($classes);
    }

    public function store(Request $request)
    {
        $user = $request->user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $class = SchoolClass::create([
            'teacher_id' => $user->id,
            'name' => trim($validated['name']),
        ]);

        $class->load('activeCode');

        return response()->json($class, 201);
    }

    public function destroy(Request $request, SchoolClass $class)
    {
        $user = $request->user();
        abort_unless($class->teacher_id === $user->id, 403);

        $class->delete();

        return response()->json(['message' => 'Class deleted']);
    }
}
