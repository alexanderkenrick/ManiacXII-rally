<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Team;
use App\Models\TreasureMap;
use App\Models\TreasurePlayer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Stmt\Switch_;

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
        $shovel = $team->item()->wherePivot("items_id", 1)->get();
        $shovel[0]->pivot->count = 1;
        $angelStatus = $team_pos->angel_active;
        $shovel[0]->pivot->save();
        return response()->json(array([
            'shovel' => $shovel[0]->pivot->count,
            'angelStatus' => $angelStatus,
            'moves' => $moves,
            'krona' => $team->currency,
        ]), 200);
    }

    public function refreshInventory(Request $request)
    {
        $team = Team::where("id", "=", $request['id'])->first();
        $team_pos = TreasurePlayer::where("teams_id", "=", $request['id'])->first();
        $moves = $team_pos->move_left;
        $shovel = $team->item()->wherePivot("items_id", 1)->get();
        $angelStatus = $team_pos->angel_active;

        return response()->json(array([
            'shovel' => $shovel[0]->pivot->count,
            'angelStatus' => $angelStatus,
            'moves' => $moves,
            'krona' => $team->currency,
        ]), 200);
    }

    public function startPosition(Request $request)
    {
        $row = $request['row'];
        $col = $request['col'];
        $moves = 10;
        $msg = "Team is already playing";
        $team_pos = TreasurePlayer::where("teams_id", '=', $request['team_id'])->first();
        if (!$team_pos) {
            $team_in_pos = DB::table('treasure_players')
                ->where('row', '=', $row)
                ->where('column', '=', $col)
                ->get();
            if (count($team_in_pos) == 2) {

                $status = false;
            } else {

                $status = true;;
            }
            if ($status != false) {
                $team_pos = new TreasurePlayer();
                $team_pos->teams_id = $request['team_id'];
                $team_pos->move_left = 1;
                $team_pos->row = $row;
                $team_pos->column = $col;
                $team_pos->move_left = $moves;
                $team_pos->save();
                $msg = "";
                TreasureController::createInventory($request['team_id']);
            } else {
                $msg = "Cannot start there tile's too full";
            }
        }

        return response()->json(array([
            'xPos' => $row,
            'yPos' => $col,
            'moves' => $moves,
            'msg' => $msg,
        ]), 200);
    }

    //Waktu Start Position
    public function createInventory($team)
    {
        for ($i = 1; $i <= 3; $i++) {
            if ($i == 1) {
                DB::table('inventories')->insert([
                    'teams_id' => $team,
                    'items_id' => $i,
                    'count' => 0,
                ]);
            } else {
                DB::table('inventories')->insert([
                    'teams_id' => $team,
                    'items_id' => $i,
                    'count' => 0,
                ]);
            }
        }
    }

    public function addShovel(Request $request)
    {
        $team = Team::where("id", '=', $request['id'])->first();
        $item = $team->item()->wherePivot("items_id", 1)->get();

        $item[0]->pivot->count += 1;
        $item[0]->pivot->save();
    }

    public function removeShovel(Request $request)
    {
        $team = Team::where("id", '=', $request['id'])->first();
        $item = $team->item()->wherePivot("items_id", 1)->get();

        $item[0]->pivot->count -= 1;
        $item[0]->pivot->save();
    }

    public function buyItem(Request $request)
    {
        $team = Team::where("id", '=', $request['id'])->first();
        $item = $team->item()->wherePivot("items_id", $request['items_id'])->get();
        $msg = "Not Enough Krona!";
        if ($request['items_id'] == 1) {
            if (($team->currency - 100) >= 0) {
                $item[0]->pivot->count += 1;
                $item[0]->pivot->save();
                $team->currency -= 100;
                $team->save();
                $msg = "Bought 1 Shovel!";
            }
        } else if ($request['items_id'] == 2) {
            if (($team->currency - 200) >= 0) {
                $item[0]->pivot->count += 1;
                $item[0]->pivot->save();
                $team->currency -= 200;
                $team->save();
                $msg = "Bought 1 Thief Bag!";
            }
        } else if ($request['items_id'] == 3) {
            if (($team->currency - 150) >= 0) {
                $item[0]->pivot->count += 1;
                $item[0]->pivot->save();
                $team->currency -= 150;
                $team->save();
                $msg = "Bought 1 Angel Card!";
            }
        }

        return response()->json(array([
            'msg' => $msg,
            'krona' => $team->currency
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
            } else if ($col > 15) {
                $col = 15;
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
        if ($team_pos->move_left > 0) {
            if ($item[0]->pivot->count > 0) {
                $item[0]->pivot->count = 0;
                $row = $team_pos->row;
                $col = $team_pos->column;
                $map = DB::table('treasure_maps')
                    ->where('row', '=', $row)
                    ->where('column', '=', $col)
                    ->get();
                if ($map[0]->digged == 0) {
                    $krona = $map[0]->krona;
                    $map[0]->digged = 1;
                    $team->currency += $krona;

                    $msg = "Digging succeeded! you got " . $krona . " !";
                    DB::table('treasure_maps')->where('row', $row)->where('column', $col)->update(['digged' => $map[0]->digged]);
                    $team->save();
                    $team_pos->move_left -= 1;
                    $team_pos->save();
                    $item[0]->pivot->save();
                } else {

                    $team->currency;
                    $msg = "Digging failed the tile is already digged!";
                }
            } else {
                if ($team->currency >= 100) {
                    $row = $team_pos->row;
                    $col = $team_pos->column;
                    $map = DB::table('treasure_maps')
                        ->where('row', '=', $row)
                        ->where('column', '=', $col)
                        ->get();
                    if ($map[0]->digged == 0) {
                        $krona = $map[0]->krona;
                        $map[0]->digged = 1;
                        $team->currency += ($krona - 100);

                        $msg = "Digging succeeded! you bought shovel for 100 and you got " . $krona . " !";
                        DB::table('treasure_maps')->where('row', $row)->where('column', $col)->update(['digged' => $map[0]->digged]);
                        $team->save();
                        $team_pos->move_left -= 1;
                        $team_pos->save();
                        $item[0]->pivot->save();
                    } else {

                        $team->currency;
                        $msg = "Digging failed the tile is already digged!";
                    }
                } else {
                    $msg = "Your krona is not enough to use a shovel";
                }
            }
        } else {
            $msg = "You are out of moves!";
        }

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
        $opp_team = Team::where("id", '=', $opp_team_pos[0]->teams_id)->first();
        $item = $team->item()->wherePivot("items_id", 2)->get();
        if ($item[0]->pivot->count > 0) {
            $item[0]->pivot->count -= 1;

            if ($opp_team_pos[0]->angel_active  == 0) {

                $stolenKrona = floor(0.25 * $opp_team->currency);
                $team->currency += $stolenKrona;
                $opp_team->currency -= $stolenKrona;

                $msg = "Thief bag succeeded! you got " . ($stolenKrona) . " !";

                $team_pos->move_left -= 1;
                $team_pos->save();

                $opp_team->save();
                $team->save();
                $item[0]->pivot->save();
            } else {
                $opp_team_pos[0]->angel_active = 0;
                $msg = "Thief bag failed the opposing team has an angel card!";
                $item[0]->pivot->save();
                DB::table('treasure_players')->where('teams_id', $opp_team_pos[0]->teams_id)->update(['angel_active' => $opp_team_pos[0]->angel_active]);
            }
        } else {
            if ($team->currency >= 200) {
                $item[0]->pivot->count -= 1;

                if ($opp_team_pos[0]->angel_active  == 0) {

                    $stolenKrona = floor(0.25 * $opp_team->currency);
                    $team->currency += $stolenKrona;
                    $opp_team->currency -= $stolenKrona;

                    $msg = "Thief bag succeeded! you got " . ($stolenKrona) . " !";
                    $team->currency -= 200;
                    $opp_team->save();
                    $team->save();
                    $team_pos->move_left -= 1;
                    $team_pos->save();
                    $item[0]->pivot->save();
                } else {
                    $opp_team_pos[0]->angel_active = 0;
                    $team->currency -= 200;
                    $msg = "Thief bag failed the opposing team has an angel card!";
                    $item[0]->pivot->save();
                    $team->save();
                    DB::table('treasure_players')->where('teams_id', $opp_team_pos[0]->teams_id)->update(['angel_active' => $opp_team_pos[0]->angel_active]);
                }
            } else {
                $msg = "You don't have enough krona to use Thief Bag!";
            }
        }
        // $opp_team_pos[0]->save();
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
        if ($item[0]->pivot->count > 0) {

            if ($team_pos->angel_active  == 0) {
                $item[0]->pivot->count -= 1;
                $team_pos->angel_active = true;
                $msg = "Using angel card succeeded!";
                $team_pos->move_left -= 1;
            } else {
                $msg = "Using angel card failed! Angel card already active!";
            }
        } else {
            if ($team->currency >= 150) {
                if ($team_pos->angel_active  == 0) {
                    $team_pos->angel_active = true;
                    $team->currency -= 150;
                    $msg = "Using angel card succeeded!";
                    $team_pos->move_left -= 1;

                } else {
                    $msg = "Using angel card failed! Angel card already active!";
                }
            } else {
                $msg = "You don't have enough krona to use Angel Card!";
            }
        }
        $team->save();
        $team_pos->save();
        $item[0]->pivot->save();
        return response()->json(array([
            'msg' => $msg,
        ]), 200);
    }
}
