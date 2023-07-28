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

            if ($col < 1) {
                $col = 1;
                $move_left += 1;
            } else if ($col > 10) {
                $col = 10;
                $move_left += 1;
            }
            if ($row < 1) {
                $row = 1;
                $move_left += 1;
            } else if ($row > 10) {
                $row = 10;
                $move_left += 1;
            }

            $team_in_pos = DB::table('treasure_players')
                ->where('row', '=', $row)
                ->where('column', '=', $col)
                ->get();
            if (count($team_in_pos) == 2) {
                $row = $team_pos->row;
                $col = $team_pos->column;
                $status = false;
            } else {
                $team_pos->row = $row;
                $team_pos->column = $col;
                $status = false;
                $team_pos->move_left = $move_left - 1;
            }
        } else {
            $row = $team_pos->row;
            $col = $team_pos->column;
            $status = true;
            $team_pos->move_left = 0;
        }
        $move_left = $team_pos->move_left;
        $team_pos->save();
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
        $teams = TreasurePlayer::all();
        return response()->json(array([
            'array_Map' => $map,
            'array_Team' => $teams,
        ]), 200);
    }

    // public function getPlayer()
    // {
    //     $teams = TreasurePlayer::all();
    //     return $team;
    // }

    public function useShovel(Request $request)
    {
        $team_pos = TreasurePlayer::where("teams_id", '=', $request['team_id'])->first();
        $team = Team::where("id", '=', $request['id'])->first();
        $item = $team->item()->wherePivot("items_id", 1)->get();
        if ($item->pivot->count > 0) {
            $item->pivot->count -= 1;
            $row = $team_pos->row;
            $col = $team_pos->column;
            $map = DB::table('treasure_maps')
                ->where('row', '=', $row)
                ->where('column', '=', $col)
                ->get();
            if ($map->digged == false) {
                $krona = $map->krona;
                $map->digged = true;
                $team->currency += $krona;

                $msg = "Digging succeeded! you got " . $krona . " !";
            } else {
                $team->currency;
                $msg = "Digging failed the tile is already digged!";
            }
        } else {
            $msg = "You don't have enough shovel!";
        }
        $map->save();
        $team->save();
        $item->save();
        return response()->json(array([
            'msg' => $msg,
            'krona' => $team->currency
        ]), 200);
    }

    public function useThief(Request $request)
    {
        $team_pos = TreasurePlayer::where("teams_id", '=', $request['team_id'])->first();
        $team = Team::where("id", '=', $request['id'])->first();

        $row = $team_pos->row;
        $col = $team_pos->column;

        $opp_team_pos = DB::table('treasure_players')
            ->where('row', '=', $row)
            ->where('column', '=', $col)
            ->where('teams_id', '!=', $request['team_id'])
            ->get();
        $opp_team = Team::where("id", '=', $opp_team_pos->teams_id)->first();

        $item = $team->item()->wherePivot("items_id", 2)->get();
        if ($item->pivot->count > 0) {
            $item->pivot->count -= 1;

            if ($opp_team_pos->angel_active  == false) {

                $opp_team->currency -= (0.25 * $opp_team->currency);
                $team->currency += (0.25 * $opp_team->currency);


                $msg = "Thief bag succeeded! you got " . (0.25 * $opp_team->currency) . " !";
            } else {
                $opp_team_pos->angel_active = false;
                $msg = "Thief bag failed the opposing team has an angel card!";
            }
        } else {
            $msg = "You don't have enough thief bag!";
        }
        $opp_team->save();
        $team->save();
        $item->save();
        return response()->json(array([
            'msg' => $msg,
            'krona' => $team->currency
        ]), 200);
    }

    public function useAngel(Request $request)
    {
        $team_pos = TreasurePlayer::where("teams_id", '=', $request['team_id'])->first();
        $team = Team::where("id", '=', $request['id'])->first();
        $item = $team->item()->wherePivot("items_id", 3)->get();
        if ($item->pivot->count > 0) {

            if ($team_pos->angel_active  == false) {
                $item->pivot->count -= 1;
                $team_pos->angel_active = true;
                $msg = "Using angel card succeeded!";
            } else {
                $msg = "Using angel card failed! Angel card already active!";
            }
        } else {
            $msg = "You don't have enough angel card!";
        }
        $team_pos->save();
        $item->save();
        return response()->json(array([
            'msg' => $msg,
        ]), 200);
    }
}
