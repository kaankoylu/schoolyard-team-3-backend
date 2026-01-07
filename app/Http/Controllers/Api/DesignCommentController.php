<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Design;
use App\Models\DesignComment;
use Illuminate\Http\Request;

class DesignCommentController extends Controller
{
    public function index(Design $design)
    {
        return response()->json(
            $design->comments()->orderBy('id', 'desc')->get()
        );
    }

    public function store(Request $request, Design $design)
    {
        $data = $request->validate([
            'class_id' => 'nullable|integer',
            'student_name' => 'required|string|max:255',
            'session_id' => 'required|string|max:64',
            'text' => 'required|string|min:1|max:300',
        ]);

        $comment = DesignComment::create([
            'design_id' => $design->id,
            ...$data,
        ]);

        return response()->json($comment, 201);
    }
}
