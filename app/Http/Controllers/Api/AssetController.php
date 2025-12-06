<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Asset;
use Illuminate\Http\Request;   // <-- IMPORTANT

class AssetController extends Controller
{
    public function index()
    {
        return response()->json(Asset::all());
    }

    public function show(Asset $asset)
    {
        return response()->json($asset);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'label' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:assets,slug',
            'width' => 'required|integer|min:1|max:10',
            'height' => 'required|integer|min:1|max:10',
            'image' => 'required|image|mimes:png,jpg,jpeg,webp|max:4096',
        ]);

        $path = $request->file('image')->store('assets', 'public');

        $asset = Asset::create([
            'label' => $validated['label'],
            'slug' => $validated['slug'],
            'width' => $validated['width'],
            'height' => $validated['height'],
            'image_url' => "/storage/" . $path,
        ]);

        return response()->json($asset, 201);
    }
    public function update(Request $request, Asset $asset)
    {
        $data = $request->validate([
            'is_available' => 'required|boolean',
        ]);

        $asset->is_available = $data['is_available'];
        $asset->save();

        return response()->json($asset);
    }
}
