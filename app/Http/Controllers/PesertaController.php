<?php

namespace App\Http\Controllers;

use App\Models\Point;
use App\Models\Post;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PesertaController extends Controller
{
    public function index()
    {
        $account = auth()->user();
        $team = Team::where('account_id', $account->id)->first();
//        $point = Point::where('team_id', $team->id)->sum();
        $currency = $team->currency;

        $history = $this->showHistory($account);
        $postNames = $this->getPostName($history); 
        return view('/peserta/dashboard', compact('team', 'currency','history','postNames'));
    }

    public function showHistory($account){
        $history = Point::where('team_id', $account->team->id)->get();

        return $history ;
    }

    public function getPostName($history){
        $postArr = [];
        foreach($history as $data){
            $postArr[]=$postName = Post::where('id', $data['post_id'])->first()->name;
        }
        return $postArr;
    }
}
