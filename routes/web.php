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

Route::group(['middleware' => ['auth', 'admin']],
    function () {
        Route::get('/leaderboard', [\App\Http\Controllers\AdminController::class, 'index']);
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
        Route::get('/penpos', [\App\Http\Controllers\PenposController::class, 'index'])->name('penpos.home');
        Route::post('/penpos-input', [\App\Http\Controllers\PenposController::class, 'inputPoin'])->name('penpos.input');
        Route::post('/penpos-update', [\App\Http\Controllers\PenposController::class, 'updateCurrency'])->name('penpos.update');

        // SALVOS
        Route::get('/salvos', [\App\Http\Controllers\SalvosController::class, 'index'])->name('salvos.home');
        Route::post('/salvos-load', [\App\Http\Controllers\SalvosController::class, 'load'])->name('salvos.load');
        Route::post('/salvos-playerAttack', [\App\Http\Controllers\SalvosController::class, 'prosesPlayerAttack'])->name('salvos.playerAttack');
        Route::post('/salvos-enemyAttack', [\App\Http\Controllers\SalvosController::class, 'prosesEnemyAttack'])->name('salvos.enemyAttack');
        Route::post('/salvos-upgrade', [\App\Http\Controllers\SalvosController::class, 'upgradeWeap'])->name('salvos.upgrade');
        Route::post('/salvos-buypotion', [\App\Http\Controllers\SalvosController::class, 'buyPotion'])->name('salvos.buyPotion');
        Route::post('/salvos-revive', [\App\Http\Controllers\SalvosController::class, 'revive'])->name('salvos.revive');
        Route::post('/salvos-powerup', [\App\Http\Controllers\SalvosController::class, 'powerup'])->name('salvos.powerup');


    }
);

Route::group(['middleware' => ['auth', 'treasure']],
    function(){
        // TREASURE
        Route::get('/treasure', [\App\Http\Controllers\TreasureController::class, 'index'])->name('treasure');
        Route::post('/treasure-invCheck', [\App\Http\Controllers\TreasureController::class, 'getTeamInventory'])->name('treasure.getInv');
        Route::post('/treasure-refInv', [\App\Http\Controllers\TreasureController::class, 'refreshInventory'])->name('treasure.refInv');
        Route::post('/treasure-updatePost', [\App\Http\Controllers\TreasureController::class, 'updatePosition'])->name('treasure.updatePost');
        Route::post('/treasure-updateMap', [\App\Http\Controllers\TreasureController::class, 'getMap'])->name('treasure.updateMap');
        Route::post('/treasure-startPost', [\App\Http\Controllers\TreasureController::class, 'startPosition'])->name('treasure.startPost');
        Route::post('/treasure-useShovel', [\App\Http\Controllers\TreasureController::class, 'useShovel'])->name('treasure.useShovel');
        Route::post('/treasure-useThief', [\App\Http\Controllers\TreasureController::class, 'useThief'])->name('treasure.useThief');
        Route::post('/treasure-useAngel', [\App\Http\Controllers\TreasureController::class, 'useAngel'])->name('treasure.useAngel');
        Route::post('/treasure-buyItem', [\App\Http\Controllers\TreasureController::class, 'buyItem'])->name('treasure.buyItem');
        Route::post('/treasure-addShovel', [\App\Http\Controllers\TreasureController::class, 'addShovel'])->name('treasure.addShovel');
        Route::post('/treasure-removeShovel', [\App\Http\Controllers\TreasureController::class, 'removeShovel'])->name('treasure.removeShovel');
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

//Route::get('/leaderboard', function(){
//    return view('leaderboard');
//});

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
