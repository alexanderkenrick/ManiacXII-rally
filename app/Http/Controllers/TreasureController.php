<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Team;
use App\Models\TreasureMap;
use App\Models\TreasurePlayer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TreasureController extends Controller
{
    public function index()
    {
        $teams = Team::all();
        $account = auth()->user();
        $penpos = Post::where('penpos_id', Auth::user()->id)->first();

        return view('treasure', compact('teams', 'penpos'));
    }

    public function getTeamInventory(Request $request)
    {
        $team = Team::where("id", "=", $request['id'])->first();
        $team_pos = TreasurePlayer::where("teams_id", "=", $request['id'])->first();
        $team_pos->move_left = 10;
        $moves = $team_pos->move_left;
        $team_pos->save();
        $item_id = [1, 2, 3];
        $item_amount = [];
        foreach ($item_id as $id) {
            $item = $team->item()->wherePivot("items_id", $id)->get();

            if (count($item) != 0) {
                array_push($item_amount, $item[0]->pivot->count);
            } else {
                array_push($item_amount, 0);
            }
        }
        return response()->json(array([
            'teamInventory' => $item_amount,
            'moves' => $moves,
            'krona' => $team->currency,
        ]), 200);
    }

    public function startPosition(Request $request)
    {
        $row = $request['row'];
        $col = $request['col'];
        $moves = 10;

        $team_pos = TreasurePlayer::where("teams_id", '=', $request['team_id'])->first();

        $team_pos->row = $row;
        $team_pos->column = $col;
        $team_pos->move_left = $moves;
        $team_pos->save();


        return response()->json(array([
            'xPos' => $row,
            'yPos' => $col,
            'moves' => $moves
        ]), 200);
    }

    public function updatePosition(Request $request)
    {
        $xMove = $request['xMove'];
        $yMove = $request['yMove'];

        $team_pos = TreasurePlayer::where("teams_id", '=', $request['team_id'])->first();
        $move_left = $team_pos->move_left;

        if ($move_left > 0) {
            $col = ($team_pos->column) + ($xMove);
            $row = ($team_pos->row) + ($yMove);

            if ($col < 0) {
                $col = 1;
            } else if ($col > 10) {
                $col = 10;
            }
            if ($row < 0) {
                $row = 1;
            } else if ($row > 10) {
                $row = 10;
            }

            $team_in_pos = DB::table('treasure_players')
                ->where('row', '=', $row)
                ->where('column', '=', $col)
                ->get();
            if (count($team_in_pos) == 2) {
                $row = $team_pos->row;
                $col = $team_pos->column;
                $status = false;
                $team_pos->save();
            } else {
                $team_pos->row = $row;
                $team_pos->column = $col;
                $status = false;
                $team_pos->move_left = $move_left - 1;

                $team_pos->save();
            }
        } else {
            $row = $team_pos->row;
            $col = $team_pos->column;
            $status = true;
            $team_pos->move_left = 0;

            $team_pos->save();
        }
        $move_left = $team_pos->move_left;
        return response()->json(array([
            'xPos' => $col,
            'yPos' => $row,
            'outOfMove' => $status,
            'moves' => $move_left
        ]), 200);
    }

    public function getMap()
    {
        $map = TreasureMap::all();
        return response()->json(array([
            'array_Map' => $map
        ]), 200);
    }

    public function getPlayer()
    {
        $teams = TreasurePlayer::all();
        return response()->json(array([
            'array_Team' => $teams
        ]), 200);
    }

    public function useShovel(Request $request)
    {

        $team = TreasurePlayer::where("teams_id", '=', $request['team_id'])->first();

    }
}
