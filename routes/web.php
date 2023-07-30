<?php

use App\Http\Middleware\PenposMiddleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Symfony\Component\Routing\Route as RoutingRoute;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () { return view('auth.login');});
Auth::routes();

Route::group(['middleware' => ['guest']],
    function(){
        Route::get('/', function () { return view('auth.login');});
    }
    
);

//Route::get('/penpos', function() {
//    return view('penpos.input');
//})->name('input-penpos');

// Route::middleware([PenposMiddleware::class])->group(
//     function () {
//         Route::get('/penpos', [\App\Http\Controllers\PenposController::class, 'index'])->name('penpos.home');
//         Route::post('/penpos-input', [\App\Http\Controllers\PenposController::class, 'inputPoin'])->name('penpos.input');
//         Route::post('/penpos-update', [\App\Http\Controllers\PenposController::class, 'updateCurrency'])->name('penpos.update');
//     }
// );
Route::group(['middleware' => ['auth', 'penpos']],
    function(){
        Route::get('/salvos', [\App\Http\Controllers\SalvosController::class, 'index']);
        Route::get('/penpos', [\App\Http\Controllers\PenposController::class, 'index'])->name('penpos.home');
        Route::post('/penpos-input', [\App\Http\Controllers\PenposController::class, 'inputPoin'])->name('penpos.input');
        Route::post('/penpos-update', [\App\Http\Controllers\PenposController::class, 'updateCurrency'])->name('penpos.update');
        Route::get('/treasure', [\App\Http\Controllers\TreasureController::class, 'index'])->name('treasure');
        Route::post('/treasure-invCheck', [\App\Http\Controllers\TreasureController::class, 'getTeamInventory'])->name('treasure.getInv');
        Route::post('/treasure-updatePost', [\App\Http\Controllers\TreasureController::class, 'updatePosition'])->name('treasure.updatePost');
        Route::post('/treasure-updateMap', [\App\Http\Controllers\TreasureController::class, 'getMap'])->name('treasure.updateMap');
        Route::post('/treasure-startPost', [\App\Http\Controllers\TreasureController::class, 'startPosition'])->name('treasure.startPost');
        Route::post('/treasure-useShovel', [\App\Http\Controllers\TreasureController::class, 'useShovel'])->name('treasure.useShovel');
    }
);

Route::group(['middleware' => ['auth', 'peserta']],
    function () {
        Route::get('/peserta/dashboard', [\App\Http\Controllers\PesertaController::class, 'index'])->name('peserta.dashboard');
    }
);
    
Route::get('/battle', function(){
    return view('battle');
});

/*Route::get('/treasure', function(){
    return view('treasure');
});*/



// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
