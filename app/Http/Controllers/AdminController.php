<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Point;
use App\Models\Post;
use App\Models\SalvosGame;
use App\Models\SalvosRevive;
use App\Models\Team;
use http\Env\Response;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $teams = Team::all();
        $teamsData = [];

        foreach ($teams as $team) {
            $rallyPoint = Point::where('team_id', $team->id)->sum('point') * 0.6;
            $gameBesPoint = 0;
//            $gameBesPoint = 50;
//            // Buat cek sortingan e (Kalo udh fix dihapus ae)
//            if ($team->id == 2) {
//                $gameBesPoint = 20;
//            }

            $salvosGame = SalvosGame::where("teams_id", $team->id)->first();
            if ($salvosGame) {
                $isWin =  $salvosGame["enemy_hp"] == "0";
                $playerHP = $salvosGame["player_hp"];
                $totalDamage = 10000 - $salvosGame["enemy_hp"];
                $reviveCount = SalvosRevive::where("salvos_games_id", $team->id)->get();
                $reviveCount = count($reviveCount);

                $gameBesPoint = ($reviveCount * -50) + $playerHP + $totalDamage;

                if ($isWin) {
                    $gameBesPoint += 2500 - (($salvosGame->turn - 30) * 50);
                } else {
                    $gameBesPoint -= 1250;
                }

                $gameBesPoint = $gameBesPoint * 0.4;
                if($totalDamage == 0){
                    $gameBesPoint = 0;
                }
            }

//            dd($gameBesPoint);

            $totalPoint = $rallyPoint + ($gameBesPoint);
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
        array_multisort(
            array_column($teamsData, "total_point"),
            SORT_DESC,
            array_column($teamsData, "rally_point"),
            SORT_DESC,
            $teamsData
        );

        return view('leaderboard', compact('teamsData'));

    }

    public function load(Request $request)
    {
        $teams = Team::all();
        $teamsData = [];

        foreach ($teams as $team) {
            $rallyPoint = Point::where('team_id', $team->id)->sum('point') * 6;
            $gameBesPoint = 0;
//            $gameBesPoint = 50;
//            // Buat cek sortingan e (Kalo udh fix dihapus ae)
//            if ($team->id == 2) {
//                $gameBesPoint = 20;
//            }

            $salvosGame = SalvosGame::where("teams_id", $team->id)->first();
            if ($salvosGame) {
                $isWin =  $salvosGame["enemy_hp"] == "0";
                $playerHP = $salvosGame["player_hp"];
                $totalDamage = 10000 - $salvosGame["enemy_hp"];
                $reviveCount = SalvosRevive::where("salvos_games_id", $team->id)->get();
                $reviveCount = count($reviveCount);

                $gameBesPoint = ($reviveCount * -50) + $playerHP + $totalDamage;

                if ($isWin) {
                    $gameBesPoint += 2500 - (($salvosGame->turn - 30) * 50);
                } else {
                    $gameBesPoint -= 1250;
                }

                $gameBesPoint = $gameBesPoint * 0.4;
                if($totalDamage == 0){
                    $gameBesPoint = 0;
                }
            }

//            dd($gameBesPoint);

            $totalPoint = $rallyPoint + ($gameBesPoint);
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
        array_multisort(
            array_column($teamsData, "total_point"),
            SORT_DESC,
            array_column($teamsData, "rally_point"),
            SORT_DESC,
            $teamsData
        );

        return response()->json(array([
            'data' => $teamsData
        ]), 200);
    }

    public function getRincian(Request $request) {
        $teamId = $request->get('id');
        $team = Team::where('id', $teamId)->first();
        $salvosGame = SalvosGame::where('teams_id', $teamId)->first();

        // Kalo belum main (nggak tercatat)
        if (!$salvosGame) {
            return response()->json(array([
                'status' => false,
                'team_name' => $team->account->name
            ]), 200);
        }

        $revive = SalvosRevive::where("salvos_games_id", $salvosGame->id)->count();
        $isWin =  $salvosGame["enemy_hp"] == "0";
        $playerHP = $salvosGame["player_hp"];
        $totalDamage = 10000 - $salvosGame["enemy_hp"];
        $playerTurn = $salvosGame->turn;

        $gameBesPoint = ($revive * -50) + $playerHP + $totalDamage;

        if ($isWin) {
            $gameBesPoint += 2500 - (($playerTurn - 30) * 50);
        } else {
            $gameBesPoint -= 1250;
        }

        $gameBesPoint = $gameBesPoint * 0.4;

        return response()->json(array([
            'status' => true,
            'team_name' => $team->account->name,
            'keputusan' => ($isWin) ? "Menang" : "Kalah",
            'player_hp' => $playerHP,
            'total_damage' => $totalDamage,
            'turn' => $playerTurn,
            'game_bes_point' => $gameBesPoint,
            'revive' => ($revive == '0') ? 0 : $revive
        ]), 200);
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
