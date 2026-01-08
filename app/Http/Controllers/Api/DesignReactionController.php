<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Design;
use App\Models\DesignReaction;
use Illuminate\Http\Request;

class DesignReactionController extends Controller
{
    public function react(Request $request, Design $design)
    {
        $data = $request->validate([
            'class_id' => 'nullable|integer',
            'session_id' => 'required|string|max:64',
            'reaction' => 'required|integer|in:-1,0,1', // 0 = clear
        ]);

        if ($data['reaction'] === 0) {
            DesignReaction::where('design_id', $design->id)
                ->where('session_id', $data['session_id'])
                ->delete();
        } else {
            DesignReaction::updateOrCreate(
                ['design_id' => $design->id, 'session_id' => $data['session_id']],
                ['reaction' => $data['reaction'], 'class_id' => $data['class_id'] ?? null]
            );
        }

        $likes = DesignReaction::where('design_id', $design->id)->where('reaction', 1)->count();
        $dislikes = DesignReaction::where('design_id', $design->id)->where('reaction', -1)->count();

        return response()->json([
            'design_id' => $design->id,
            'likes' => $likes,
            'dislikes' => $dislikes,
            'score' => $likes - $dislikes,
        ]);
    }
}
