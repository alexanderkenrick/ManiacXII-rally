<?php

namespace App\Http\Controllers;

use App\Models\Point;
use App\Models\Post;
use App\Models\Team;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $teams = Team::all();
        $teamsData = [];

        foreach ($teams as $team) {
            $rallyPoint = Point::where('team_id', $team->id)->sum('point') * 0.6;
            $gameBesPoint = 50;
            // Buat cek sortingan e (Kalo udh fix dihapus ae)
            if ($team->id == 2) {
                $gameBesPoint = 20;
            }
            $totalPoint = $rallyPoint + $gameBesPoint;
            $arr = [
                "team_id" => $team->id,
                "rally_point" => $rallyPoint,
                "game_besar_point" => $gameBesPoint,
                "total_point" => $totalPoint
            ];
            $teamsData += array($team->account->name => $arr);
        }

//        $teamsData = collect($teamsData)->sort()->reverse()->toArray();

        // Sort berdasarkan Total Point
        array_multisort( array_column($teamsData, "total_point"), SORT_DESC, $teamsData);
        return view('leaderboard', compact('teamsData'));

    }

    public function getHistory(Request $request) {
        $teamId = $request->get('id');
        $history = $this->history($teamId);
        $postNames = $this->getPostName($history);
        return response()->json(array([
            'history' => $history,
            'postNames' => $postNames
        ]), 200);
    }

    public function history($id) {
        $history = Point::where('team_id', $id)->get();

        return $history;
    }

    public function getPostName($history) {
        $postArr = [];

        foreach ($history as $data) {
            $postArr[] = Post::where('id', $data['post_id'])->first()->name;
        }

        return $postArr;
    }
}
