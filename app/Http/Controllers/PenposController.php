<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Point;
use App\Models\Post;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use PhpParser\Node\Expr\Cast\Object_;

class PenposController extends Controller
{
    public function index()
    {
        $teams = Team::all();
        $account = auth()->user();
        $penpos = Post::where('penpos_id', Auth::user()->id)->first();

        return view('penpos.input', compact('teams', 'penpos'));
    }


    public function inputPoin(Request $request)
    {
        // Pengecekan textbox
        $validator = Validator::make($request->all(), [
            'team_name' => 'required',
            'poin' => 'required'
        ]);
        // Klu gagal
        if ($validator->fails()) {
            $request->session()->flash('valid', 'false');
            return view('penpos.home');
        }
        //Klu berhasil
        else {
            $request->session()->flash('valid', 'true');
            $teamName = request()->get('team_name');
            $teamId = PenposController::searchByName($teamName);
            $penposId = Post::where('penpos_id', Auth::user()->id)->first()->id;
            $poin = $request->get('poin');

            $addPoint = new Point();
            $addPoint->post_id = $penposId;
            $addPoint->team_id = $teamId;
            $addPoint->point = $poin;
            $addPoint->save();

            $this->updateCurrency($teamId, $poin);
        }

        return response()->json(array([
            'msg' => 'Success'
        ]), 200);
    }

    public function updateCurrency($teamId, $poin)
    {
        $currCurrency = Team::where('id', $teamId)->first()->currency;
        $multiplier = 1;
        $updatedCurr = $currCurrency + $poin * $multiplier;

        Team::where('id', $teamId)->update(['currency' => $updatedCurr]);
    }

    public function searchByName($teamName)
    {
        $accId = Account::where('name', $teamName)->first()->id;
        $teamId = Team::where('account_id', $accId)->first()->id;
        return $teamId;
    }
}
