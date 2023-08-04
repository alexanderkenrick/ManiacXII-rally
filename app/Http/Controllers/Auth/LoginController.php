<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
//use http\Env\Request;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;
//    private $redirectTo = "";
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    public function index(Request $request)
    {
        return view('login-new');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required']
        ]);

        if (Auth::attempt($credentials))
        {
            $request->session()->regenerate();

            if (Auth::user()->role === "0")
            {
//                $redirectTo = RouteServiceProvider::ADMIN;
                return redirect()->intended('/leaderboard');
            }
            else if (Auth::user()->role === "1")
            {
//                $redirectTo = RouteServiceProvider::PENPOS;
                return redirect()->intended('/penpos');
            }
            else if (Auth::user()->role === "2")
            {
//                $redirectTo = RouteServiceProvider::TEAM;
                return redirect()->intended('/peserta/dashboard');
            }
            else if (Auth::user()->role === "3")
            {
//                $redirectTo = RouteServiceProvider::TEAM;
                return redirect()->intended('/treasure');
            }
            else if (Auth::user()->role === "4")
            {
//                $redirectTo = RouteServiceProvider::TEAM;
                return redirect()->intended('/salvos');
            }
        
        }

        return back()->with('loginError', 'Login Gagal, kombinasi username dan password salah!');
    }
}
