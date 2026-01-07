<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Design;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DesignFeedController extends Controller
{
    public function feed(Request $request)
    {
        $sessionId = $request->query('session_id'); // optional
        $perPage = min(max((int)$request->query('per_page', 10), 1), 30);

        $q = Design::query()
            ->with('schoolClass')
            ->select('design.*')
            ->selectSub(function ($q) {
                $q->from('design_reactions')
                    ->selectRaw('COUNT(*)')
                    ->whereColumn('design_reactions.design_id', 'design.id')
                    ->where('reaction', 1);
            }, 'likes')
            ->selectSub(function ($q) {
                $q->from('design_reactions')
                    ->selectRaw('COUNT(*)')
                    ->whereColumn('design_reactions.design_id', 'design.id')
                    ->where('reaction', -1);
            }, 'dislikes')
            ->orderByDesc('id');

        // include my reaction in feed (so UI can highlight)
        if ($sessionId) {
            $q->selectSub(function ($q) use ($sessionId) {
                $q->from('design_reactions')
                    ->select('reaction')
                    ->whereColumn('design_reactions.design_id', 'design.id')
                    ->where('session_id', $sessionId)
                    ->limit(1);
            }, 'my_reaction');
        }

        return response()->json($q->paginate($perPage));
    }

    public function leaderboard(Request $request)
    {
        $limit = min(max((int)$request->query('limit', 10), 1), 50);

        $rows = DB::table('design')
            ->leftJoin('design_reactions as r', 'r.design_id', '=', 'design.id')
            ->select(
                'design.id',
                'design.student_name',
                'design.class_id',
                DB::raw("SUM(CASE WHEN r.reaction = 1 THEN 1 ELSE 0 END) as likes"),
                DB::raw("SUM(CASE WHEN r.reaction = -1 THEN 1 ELSE 0 END) as dislikes"),
                DB::raw("(SUM(CASE WHEN r.reaction = 1 THEN 1 ELSE 0 END) - SUM(CASE WHEN r.reaction = -1 THEN 1 ELSE 0 END)) as score")
            )
            ->groupBy('design.id', 'design.student_name', 'design.class_id')
            ->orderByDesc('score')
            ->orderByDesc('likes')
            ->orderByDesc('design.id')
            ->limit($limit)
            ->get();

        return response()->json($rows);
    }
}
