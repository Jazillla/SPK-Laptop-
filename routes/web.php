<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Compare;
use App\Http\Controllers\LaptopController;
use App\Http\Controllers\BobotController;
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
Route::get('/laptops/create', function() {
    dd('Tes akses route /'); // Die and Dump
});
Route::get('/', [BobotController::class, 'create'])->name('bobot.create');
Route::post('/bobot', [BobotController::class, 'store'])->name('bobot.store');
Route::get('/bobot/history', [BobotController::class, 'history'])->name('bobot.history');


Route::get('/laptops/{laptop}', [LaptopController::class, 'show'])->name('laptops.show');
Route::get('/laptops/create', [LaptopController::class, 'create'])->name('laptops.create');
Route::post('/laptops', [LaptopController::class, 'store'])->name('laptops.store');
Route::delete('/laptops/{laptop}', [LaptopController::class, 'destroy'])
     ->name('laptops.destroy');
Route::get('/ranking', [LaptopController::class, 'ranking'])->name('laptops.ranking');
