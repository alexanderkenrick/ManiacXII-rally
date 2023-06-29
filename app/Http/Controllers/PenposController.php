<?php

namespace App\Http\Controllers;

use App\Models\Point;
use App\Models\Post;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PhpParser\Node\Expr\Cast\Object_;

class PenposController extends Controller
{
    public function index()
    {
        $teams = Team::all();
        $account = auth()->user();
        return view('penpos.input', compact('teams'));
    }

    public function updateCurrency(Request $request)
    {
        $teamId = $request->get('team_id');
        $poin = $request->get('poin');
        dd($teamId);

        $currCurrency = Team::find($teamId)->first()->currency;


        Team::where('id', $teamId)->update(['currency' => $currCurrency + $poin]);


//        DB::table('teams')->where('id', $teamId)->update([
//            'currency' => $currCurrency + $poin * 1
//        ]);

        return response()->json(array([
            'msg' => 'Success'
        ]), 200);

    }

    public function inputPoin(Request $request)
    {
        $teamId = $request->get('team_id');
        $penposId = Post::where('penpos_id', Auth::user()->id)->first()->id;
        $poin = $request->get('poin');

//        DB::table('points')->where([
//            'post_id' => $penposId,
//            'team_id' => $teamId
//        ]);

        $point = new Point();
        $point->post_id = $penposId;
        $point->team_id = $teamId;
        $point->point = $poin;
        $point->save();

        return response()->json(array([
            'msg' => 'Success'
        ]), 200);
    }

    public function ambilTeam()
    {
        //
    }
}
