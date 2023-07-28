<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
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
        $salvosGame = SalvosGame::where('id', Auth::user()->team()->id)->first();
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
        
        return view('salvos.home', compact('teams'));
    }
}
