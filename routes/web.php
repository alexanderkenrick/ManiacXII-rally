<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

//Route::get('/penpos', function() {
//    return view('penpos.input');
//})->name('input-penpos');
Route::get('/penpos', [\App\Http\Controllers\PenposController::class, 'index']);
Route::post('/penpos-input', [\App\Http\Controllers\PenposController::class, 'inputPoin'])->name('penpos.input');
Route::post('/penpos-update', [\App\Http\Controllers\PenposController::class, 'updateCurrency'])->name('penpos.update');

Route::get('/peserta/dashboard', [\App\Http\Controllers\PesertaController::class, 'index'])->name('peserta-dashboard');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
