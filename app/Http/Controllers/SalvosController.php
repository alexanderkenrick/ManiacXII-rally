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

    public function buyPotion(Request $request)
    {
        $team = Team::where("id", "=", $request['id'])->first();
        $salvosGame = SalvosGame::where("teams_id", "=", $request['id'])->first();
        $price1 = 100;
        $price2 = 200;
        $heal1 = 1000;
        $heal2 = 3000;
        $price = 0;
        $heal = 0;
        if ($salvosGame->player_hp <= 0)
        {
            return response()->json(array([
                'status' => false,
                'msg' => 'Tidak dapat membeli potion',
            ]), 200);
        }
        if ($request['buy'] == 1)
        {
            $price = $price1;
            $heal = $heal1;
        }
        else if ($request['buy'] == 2)
        {
            $price = $price2;
            $heal = $heal2;
        }
        if ($team->currency < $price)
        {
            return response()->json(array([
                'status' => false,
                'msg' => 'Krona tidak cukup untuk buy potion',
            ]), 200);
        }
        $updateTurn = $salvosGame->turn;

        // Pengecekan klu HP 10k gak bisa beli heal
        if($salvosGame->player_hp != 10000){
            $team->update([
                'currency' => $team->currency - $price,
            ]);
            $updateTurn = $salvosGame->turn + 1;
        }
        // Pengecekan klu setelah heal, health lbh dr 10k
        if($salvosGame->player_hp + $heal>=10000){
            $heal = 10000-$salvosGame->player_hp;
        }

        $salvosGame->update([
            'turn' => $updateTurn,
            'player_hp' => $salvosGame->player_hp + $heal
        ]);
        return response()->json(array([
            'status' => true,
            'msg' => 'Berhasil membeli potion, HP mu bertambah '.$heal,
        ]), 200);
    }

    public function revive(Request $request)
    {
        $team = Team::where("id", "=", $request['id'])->first();
        $salvosGame = SalvosGame::where("teams_id", "=", $request['id'])->first();
        $price = 200;
        $reviveHP = 1000;
        if ($salvosGame->player_hp > 0)
        {
            return response()->json(array([
                'status' => false,
                'msg' => 'Tidak dapat melakukan revive',
            ]), 200);
        }
        if ($team->currency < $price)
        {
            return response()->json(array([
                'status' => false,
                'msg' => 'Krona tidak cukup untuk revive',
            ]), 200);
        }
        $team->update([
            'currency' => $team->currency - $price,
        ]);
        $updateTurn = $salvosGame->turn + 1;
        $salvosGame->update([
            'turn' => $updateTurn,
            'player_hp' => $salvosGame->player_hp + $reviveHP
        ]);

        // catet revive
        $salvosRevive = new SalvosRevive();
        $salvosRevive->salvos_games_id = $salvosGame->id;
        $salvosRevive->save();

        return response()->json(array([
            'status' => true,
            'msg' => 'Berhasil revive',
        ]), 200);
    }

    public function powerup(Request $request)
    {
        $team = Team::where("id", "=", $request['id'])->first();
        $salvosGame = SalvosGame::where("teams_id", "=", $request['id'])->first();
        $price = 100;
        $multiple = rand(0, 70) / 10;
        if ($salvosGame->player_hp <= 0)
        {
            return response()->json(array([
                'status' => false,
                'msg' => 'Tidak dapat melakukan power up',
            ]), 200);
        }
        if ($team->currency < $price)
        {
            return response()->json(array([
                'status' => false,
                'msg' => 'Krona tidak cukup untuk power up',
            ]), 200);
        }
        $team->update([
            'currency' => $team->currency - $price,
        ]);
        $updateTurn = $salvosGame->turn + 1;
        $salvosGame->update([
            'turn' => $updateTurn,
            'multiple_dmg' => $multiple
        ]);
        return response()->json(array([
            'status' => true,
            'msg' => 'Berhasil power up, mendapatkan multiple dmg x'.$multiple.' untuk serangan selanjutnya',
        ]), 200);
    }

    public function upgradeWeap(Request $request)
    {
        $team = Team::where("id", "=", $request['id'])->first();
        $salvosGame = SalvosGame::where("teams_id", "=", $request['id'])->first();
        $weapLv = $salvosGame->weap_lv;
        $price = 100;
        if ($weapLv == 2)
            $price = 150;

        if ($salvosGame->player_hp <= 0)
        {
            return response()->json(array([
                'status' => false,
                'msg' => 'Tidak dapat melakukan upgrade',
            ]), 200);
        }
        if ($team->currency < $price)
        {
            return response()->json(array([
                'status' => false,
                'msg' => 'Krona tidak cukup untuk upgrade weapon',
            ]), 200);
        }

        $updated = $weapLv + 1;
        if ($updated > 3){
            return response()->json(array([
                'status' => false,
                'msg' => 'Weapon sudah mencapai level maksimal',
            ]), 200);
        }
        $team->update(['currency' => $team->currency - $price]);
        $updateTurn = $salvosGame->turn + 1;
        $salvosGame->update([
            'weap_lv' => $updated,
            'turn' => $updateTurn
        ]);
        return response()->json(array([
            'status' => true,
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
        $multiple = $salvosGame->multiple_dmg;
        if ($multiple == 0)
            $multiple = 1;
        if ($weapLv == 1)
            $dmg = 100;
        else if ($weapLv == 2)
            $dmg = 200;
        else if ($weapLv == 3)
            $dmg = 300;
        $dmg = $dmg * $multiple;

        $updatedHP = $enemyHP - $dmg;
        $updateTurn = $turn + 1;
        $detail = 'Serangan berhasil dengan damage '.$dmg;
        if ($updatedHP < 0){
            $updatedHP = 0;
            $detail .= "\nSalvos sudah dikalahkan pada turn ".$updateTurn;
        }
        $salvosGame->update([
            'enemy_hp' => $updatedHP,
            'turn' => $updateTurn,
            'multiple_dmg' => 1
        ]);
        return response()->json(array([
            'status' => true,
            'msg' => $detail,
        ]), 200);
    }

    public function prosesEnemyAttack(Request $request)
    {
        $salvosGame = SalvosGame::where("teams_id", "=", $request['id'])->first();
        $salvosDamage = SalvosDamage::all();
        $playerHP = $salvosGame->player_hp;
        $turn = $salvosGame->turn;
        if ($turn % 3 == 0 && $salvosGame->enemy_hp > 0) // nyerangnya enemy tiap 3 turn
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
        if ($salvosGame->enemy_hp <= 0){
            return response()->json(array([
                'status' => false,
                'msg' => 'Salvos sudah dikalahkan pada turn '.$turn,
            ]), 200);
        }
        return response()->json(array([
            'status' => false,
            'msg' => 'Musuh tidak ada penyerangan',
        ]), 200);
    }
}
