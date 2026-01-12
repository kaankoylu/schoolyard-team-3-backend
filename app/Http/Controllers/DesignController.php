<?php

namespace App\Http\Controllers;

use App\Models\Design;
use Illuminate\Http\Request;
use App\Models\Asset;
class DesignController extends Controller
{
    public function index()
{
    return response()->json(
        Design::with('schoolClass')
            ->orderBy('id', 'desc')
            ->get()
            ->map(function ($design) {
                $design->placed_assets = collect($design->placed_assets)->map(function ($item) {
                    $asset = \App\Models\Asset::find($item['assetId']);

                    return array_merge($item, [
                        'asset' => $asset ? [
                            'label' => $asset->label,
                            'image_url' => $asset->image_url,
                            'width' => $asset->width,
                            'height' => $asset->height,
                        ] : null
                    ]);
                });

                return $design;
            })
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
        $design->load('schoolClass');

        $placed = collect($design->placed_assets)->map(function ($item) {
            $asset = Asset::find($item['assetId']);

            return array_merge($item, [
                'asset' => $asset ? [
                    'id' => $asset->id,
                    'label' => $asset->label,
                    'image_url' => $asset->image_url,
                    'width' => $asset->width,
                    'height' => $asset->height,
                ] : null
            ]);
        });

        $design->placed_assets = $placed;

        return response()->json($design);
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
