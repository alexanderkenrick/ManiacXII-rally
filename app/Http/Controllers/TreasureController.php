<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Team;
use App\Models\TreasureMap;
use App\Models\TreasurePlayer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
            $xPos = ($team_pos->row) + ($xMove);
            $yPos = ($team_pos->column) + ($yMove);

            if ($xPos < 0) {
                $xPos = 0;
            } else if ($xPos > 10) {
                $xPos = 10;
            }
            if ($yPos < 0) {
                $yPos = 0;
            } else if ($yPos > 10) {
                $yPos = 10;
            }

            $team_pos->row = $xPos;
            $team_pos->column = $yPos;
            $status = false;
            $team_pos->move_left = $move_left - 1;

            $team_pos->save();
        } else {

            $xPos = $team_pos->row;
            $yPos = $team_pos->column;
            $status = true;
            $team_pos->move_left = 0;

            $team_pos->save();
        }
        $move_left = $team_pos->move_left;
        return response()->json(array([
            'xPos' => $xPos,
            'yPos' => $yPos,
            'outOfMove' => $status,
            'moves' => $move_left
        ]), 200);
    }

    public function getMap(Request $request)
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
}
