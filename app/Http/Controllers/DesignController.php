<?php

namespace App\Http\Controllers;

use App\Models\Design;
use Illuminate\Http\Request;

class DesignController extends Controller
{

    public function index()
    {
        // You can add pagination later; for now return all.
        return response()->json(
            Design::orderBy('id', 'desc')->get()
        );
    }

    public function store(Request $request)
    {
        // validate exactly what your Svelte grid sends
        $data = $request->validate([
            'rows' => 'required|integer|min:1',
            'cols' => 'required|integer|min:1',
            'backgroundImage' => 'nullable|string',
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

        // adapt the field names to match your migration
        $design = Design::create([
            'rows' => $data['rows'],
            'cols' => $data['cols'],
            'background_image' => $data['backgroundImage'] ?? null,
            'placed_assets' => $data['placedAssets'],
        ]);

        return response()->json([
            'success' => true,
            'id' => $design->id,
            'design' => $design,
        ], 201);
    }

    public function show(Design $design)
    {
        return response()->json($design);
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




}
