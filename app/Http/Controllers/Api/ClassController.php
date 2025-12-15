<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SchoolClass;
use Illuminate\Http\Request;

class ClassController extends Controller
{
    public function index()
    {
        return response()->json(
            SchoolClass::with('activeCode')->orderBy('name')->get()
        );
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        // TEMP: teacher_id nullable or hardcoded (see migration note below)
        $class = SchoolClass::create([
            'teacher_id' => 1, // TEMP
            'name' => trim($validated['name']),
        ]);

        return response()->json($class->load('activeCode'), 201);
    }

    public function destroy(SchoolClass $class)
    {
        $class->delete();
        return response()->json(['message' => 'Class deleted']);
    }
}
