<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TreasureController extends Controller
{
    public function index(){
        $teams = Team::all();
        $account = auth()->user();
        $penpos = Post::where('penpos_id', Auth::user()->id)->first();

        return view('treasure', compact('teams', 'penpos'));

    }

    public function getTeamInventory(Request $request) {
        $team = Team::where("id","=", $request['id'])->first();
        $item_id = [1,2,3];
        $item_amount = [];
        foreach($item_id as $id){
            $item = $team->item()->wherePivot("items_id",$id)->get();
            
            if(count($item) != 0){
                array_push($item_amount, $item[0]->pivot->count);
            }else{
                array_push($item_amount,0);
            }
            
        }
        return response()->json(array([
            'teamInventory' => $item_amount
        ]), 200);
    }
}
