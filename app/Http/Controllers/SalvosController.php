<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use App\Models\Post;
use App\Models\Team;
use App\Models\SalvosGame;
use App\Models\SalvosRevive;
use App\Models\SalvosDamage;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class SalvosController extends Controller
{
    public function index()
    {
        $teams = Team::all();
        $account = auth()->user();
        $penpos = Post::where('penpos_id', Auth::user()->id)->first();

        return view('salvos.home', compact('teams', 'penpos'));
        // gak jadi
        /*$salvosGame = SalvosGame::where('id', Auth::user()->team()->id)->first();
        $hpPlayer = 10000;
        $hpEnemy = 10000;
        $status = 'battle'; //dead
        $salvosRevive = SalvosRevive::where('salvos_games_id', Auth::user()->$salvosGame->id)->lastInsertId();
        $salvosDamages = SalvosDamage::all();
        $interval = 0;
        $dmgPlayer = 100;
        $dmgPlayerEvery = 1;
        $dmgEnemy = 500;
        $dmgEnemyEvery = 3;
        $start = date("2023-07-27 09:00:00");
        $now = Carbon::now()->toDateTimeString();
        $interval = $now->diffInMinutes($start);
        if (!$salvosRevive.isEmpty())
        {
            $timeLastRevive = $salvosRevive->revive_time;
            $interval = $now->diffInMinutes($timeLastRevive);
        }
        $playerDmgTimes = floor($interval/$dmgPlayerEvery);
        $enemyDmgTimes = floor($interval/$dmgEnemyEvery);
        for ($i=0; $i < $playerDmgTimes; $i++) { 
            $hpEnemy -= $dmgPlayer;
        }
        for ($i=0; $i < $enemyDmgTimes; $i++) {
            $multiple = 1;
            foreach ($salvosDamages as $salvosDamage) {
                $intervalUp = $now->diffInMinutes($salvosDamage->waktu);
                if ($intervalUp <= $interval)
                    $multiple = $salvosDamage->multiple;
            }
            $hpPlayer -= $dmgEnemy * $multiple;
        }
        SalvosGame::where('id', $salvosGame->id)->update(['player_hp' => $hpPlayer, 
                                                          'enemy_hp' => $hpEnemy,
                                                          'status' => $status]);
        
        return view('salvos.home', compact('teams'));*/

    }

    public function load(Request $request)
    {
        $team = Team::where("id", "=", $request['id'])->first();
        $salvosGame = SalvosGame::where("teams_id", "=", $request['id'])->first();
        if (!$salvosGame) {
            $salvosGame = new SalvosGame();
            $salvosGame->teams_id = $request['id'];
            $salvosGame->player_hp = 10000;
            $salvosGame->enemy_hp = 10000;
            $salvosGame->weap_lv = 1;
            $salvosGame->turn = 1;
            $salvosGame->save();
        }
        return response()->json(array([
            'player_hp' => $salvosGame->player_hp,
            'enemy_hp' => $salvosGame->enemy_hp,
            'weap_lv' => $salvosGame->weap_lv,
            'krona' => $team->currency,
            'turn' => $salvosGame->turn,
        ]), 200);
    }

    public function upgradeWeap(Request $request)
    {
        $team = Team::where("id", "=", $request['id'])->first();
        $salvosGame = SalvosGame::where("teams_id", "=", $request['id'])->first();
        $weapLv = $salvosGame->weap_lv;
        $price = 150;
        if ($weapLv == 2)
            $price = 200;
        if ($team->currency < $price)
        {
            return response()->json(array([
                'msg' => 'Krona tidak cukup untuk upgrade weapon',
            ]), 200);
        }
        $team->update(['currency' => $team->currency - $price]);
        $updated = $weapLv + 1;
        if ($updated >= 3){
            return response()->json(array([
                'msg' => 'Weapon sudah mencapai level maksimal',
            ]), 200);
        }
        $updateTurn = $salvosGame->turn + 1;
        $salvosGame->update([
            'weap_lv' => $updated, 
            'turn' => $updateTurn
        ]);
        return response()->json(array([
            'msg' => 'Weapon berhasil diupgrade ke level '.$updated,
        ]), 200);
    }


    public function prosesPlayerAttack(Request $request)
    {
        $team = Team::where("id", "=", $request['id'])->first();
        $salvosGame = SalvosGame::where("teams_id", "=", $request['id'])->first();
        if ($salvosGame->player_hp <= 0)
        {
            return response()->json(array([
                'status' => false,
                'msg' => 'Tidak dapat menyerang karena sudah mati',
            ]), 200);
        }
        $enemyHP = $salvosGame->enemy_hp;
        $weapLv = $salvosGame->weap_lv;
        $turn = $salvosGame->turn;
        if ($weapLv == 1)
            $dmg = 100;
        else if ($weapLv == 2)
            $dmg = 200;
        else if ($weapLv == 3)
            $dmg = 300;
        
        $updatedHP = $enemyHP - $dmg;
        $updateTurn = $turn + 1;
        $detail = 'Serangan berhasil dengan damage '.$dmg;
        if ($updatedHP < 0){
            $updatedHP = 0;
            $bonusKrona = 2500 - $turn*10;
            $updatedKrona = $team->currency + $bonusKrona;
            $team->update([
                'currency' => $updatedKrona,
            ]);
            $detail += "\nSalvos sudah dikalahkan pada turn ".$updateTurn;
            $detail += "\nMendapatkan bonus krona ".$updatedKrona;
        }
        $salvosGame->update([
            'enemy_hp' => $updatedHP, 
            'turn' => $updateTurn, 
        ]);
        return response()->json(array([
            'status' => true,
            'msg' => $detail,
        ]), 200);
    }

    public function prosesEnemyAttack(Request $request)
    {
        $team = Team::where("id", "=", $request['id'])->first();
        $salvosGame = SalvosGame::where("teams_id", "=", $request['id'])->first();
        $salvosDamage = SalvosDamage::all();
        $playerHP = $salvosGame->player_hp;
        $weapLv = $salvosGame->weap_lv;
        $turn = $salvosGame->turn;
        if ($turn % 3 == 0) // nyerangnya enemy tiap 3 turn
        {
            $dmg = 500;
            foreach($salvosDamage as $data){
                if ($data->turn == $turn){
                    $dmg = $dmg * $data->multiple;
                }
            }
            $updatedHP = $playerHP - $dmg;
            if ($updatedHP < 0){
                $updatedHP = 0;
            }
            $salvosGame->update([
                'player_hp' => $updatedHP, 
            ]);
            return response()->json(array([
                'status' => true,
                'msg' => 'Musuh menyerang dengan damage '.$dmg,
            ]), 200);
        }
        return response()->json(array([
            'status' => false,
            'msg' => 'Musuh tidak ada penyerangan',
        ]), 200);
    }
}
