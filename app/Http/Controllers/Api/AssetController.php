<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Asset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AssetController extends Controller
{
    public function index()
    {
        return response()->json(Asset::orderBy('id', 'asc')->get());
    }

    public function show(Asset $asset)
    {
        return response()->json($asset);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'label' => 'required|string|max:255',
            'width' => 'required|integer|min:1|max:10',
            'height' => 'required|integer|min:1|max:10',
            'image' => 'required|image|mimes:png,jpg,jpeg,webp|max:4096',
        ]);

        // Auto-generate slug
        $slug = strtolower(str_replace(' ', '_', $validated['label']));

        // Save image
        $path = $request->file('image')->store('assets', 'public');

        $asset = Asset::create([
            'label' => $validated['label'],
            'slug' => $slug,
            'width' => $validated['width'],
            'height' => $validated['height'],
            'image_url' => "/storage/" . $path,
            'is_available' => true,
        ]);

        return response()->json($asset, 201);
    }


    public function update(Request $request, Asset $asset)
    {
        $validated = $request->validate([
            'label'       => 'sometimes|string|max:255',
            'width'       => 'sometimes|integer|min:1|max:10',
            'height'      => 'sometimes|integer|min:1|max:10',
            'is_available'=> 'sometimes|boolean',
            'image'       => 'sometimes|nullable|image|mimes:png,jpg,jpeg,webp|max:4096',
        ]);

        // Optional label update
        if (isset($validated['label'])) {
            $asset->label = $validated['label'];
            $asset->slug = strtolower(str_replace(' ', '_', $validated['label']));
        }

        if (isset($validated['width']))  $asset->width = $validated['width'];
        if (isset($validated['height'])) $asset->height = $validated['height'];
        if (isset($validated['is_available'])) $asset->is_available = $validated['is_available'];

        // New image?
        if ($request->hasFile('image')) {
            // Delete old file
            if ($asset->image_url && Storage::disk('public')->exists(str_replace('/storage/', '', $asset->image_url))) {
                Storage::disk('public')->delete(str_replace('/storage/', '', $asset->image_url));
            }

            $path = $request->file('image')->store('assets', 'public');
            $asset->image_url = "/storage/" . $path;
        }

        $asset->save();

        return response()->json($asset);
    }


    public function destroy(Asset $asset)
    {
        // Delete image
        if ($asset->image_url && Storage::disk('public')->exists(str_replace('/storage/', '', $asset->image_url))) {
            Storage::disk('public')->delete(str_replace('/storage/', '', $asset->image_url));
        }

        $asset->delete();

        return response()->json(['message' => 'Asset deleted']);
    }
}
