<?php

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FactureController;

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

Route::get('/', [FactureController::class, 'login'])->name('mylogin');

Route::post('/mylogin', [FactureController::class, 'index'])->name('mylogin.verify');

Route::group(['middleware' => 'mylogin'], function(){

    Route::get('/logout', [FactureController::class, 'logout'])->name('mylogout');

    Route::get('/dashboard', [FactureController::class, 'dashboard'])->name('dashboard');

    Route::get('/facture', [FactureController::class, 'facture'])->name('facture.index');

    Route::get('/remove/{id}', [FactureController::class, 'remove'])->name('facture.remove');

    Route::get('/save/{list}/{customer}/{m}', [FactureController::class, 'listProduct'])->name('facture.create');

    Route::post('/search', [FactureController::class, 'search'])->name('facture.search');

    Route::post('/store', [FactureController::class, 'store'])->name('facture.store');

    Route::get('/details/{billId}/{customerId}', [FactureController::class, 'details'])->name('facture.details');

    Route::get('/delete/{billId}/{customerId}/{pass}', [FactureController::class, 'delete'])->name('facture.delete');

    Route::get('/pay/{billId}/{customerId}', [FactureController::class, 'pay'])->name('facture.pay');

});

