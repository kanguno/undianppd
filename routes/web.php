<?php

use Illuminate\Support\Facades\Route;
//use App\Http\Controllers\RegUndianController;
use App\Livewire\InputDataBill;
use App\Livewire\ValidasiDataBill;
use App\Livewire\RegDatas;
use App\Livewire\Merchant;
use App\Livewire\Dashboard;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('home');
});

Route::get('/inputdata', InputDataBill::class)->name('inputDataBill');


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    ])->group(function () {
        // Route::get('/dashboard', function () {
        //     return view('dashboard');
        // })->name('dashboard');
        
        Route::get('/dashboard', Dashboard::class)->name('dashboard');
        Route::get('/regdatas', RegDatas::class)->name('regdatas');
        Route::get('/merchants', Merchant::class)->name('merchants');
        Route::get('/regdatas/{statusid}', RegDatas::class)->name('regdatastatus');
        Route::get('/validasidata/{regid}', ValidasiDataBill::class)->name('validasidata');
    });
    