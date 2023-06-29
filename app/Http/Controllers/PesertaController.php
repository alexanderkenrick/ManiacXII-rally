<?php

namespace App\Http\Controllers;

use App\Models\Point;
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
        return view('/peserta/dashboard', compact('team', 'currency'));
    }
}
