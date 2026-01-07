<?php

namespace App\Http\Controllers;

use App\Models\Design;
use Illuminate\Http\Request;

class DesignController extends Controller
{
    public function index()
    {
        return response()->json(
            Design::with('schoolClass')->orderBy('id', 'desc')->get()
        );
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'rows' => 'required|integer|min:1',
            'cols' => 'required|integer|min:1',
            'backgroundImage' => 'nullable|string',

            // ✅ matches your SchoolClass model table = 'classes'
            'class_id' => 'nullable|integer|exists:classes,id',
            'student_name' => 'nullable|string|max:255',

            'placedAssets' => 'required|array',
            'placedAssets.*.instanceId' => 'required|integer',
            'placedAssets.*.assetId' => 'required|integer|exists:assets,id',
            'placedAssets.*.label' => 'required|string',
            'placedAssets.*.row' => 'required|integer|min:0',
            'placedAssets.*.col' => 'required|integer|min:0',
            'placedAssets.*.width' => 'required|integer|min:1',
            'placedAssets.*.height' => 'required|integer|min:1',
            'placedAssets.*.rotation' => 'required|integer',
        ]);

        $design = Design::create([
            'rows' => $data['rows'],
            'cols' => $data['cols'],
            'background_image' => $data['backgroundImage'] ?? null,
            'placed_assets' => $data['placedAssets'],

            'class_id' => $data['class_id'] ?? null,
            'student_name' => $data['student_name'] ?? null,
        ]);


        $design->load('schoolClass');

        return response()->json([
            'success' => true,
            'id' => $design->id,
            'design' => $design,
        ], 201);
    }

    public function show(Design $design)
    {
        return response()->json(
            $design->load('schoolClass')
        );
    }

    public function storeFeedback(Request $request, $id)
    {
        $design = Design::findOrFail($id);

        $design->feedback = $request->input('text');
        $design->save();

        return response()->json([
            'message' => 'Feedback saved',
            'feedback' => $design->feedback
        ]);
    }

    public function saveGrade(Request $request, Design $design)
    {
        $validated = $request->validate([
            'grade' => 'required|integer|min:1|max:5',
        ]);

        $design->grade = $validated['grade'];
        $design->save();

        return response()->json([
            'grade' => $design->grade,
        ]);
    }
}
