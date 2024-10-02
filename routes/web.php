<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BackOfficeController\DashboardControllerB;
use App\Http\Controllers\BackOfficeController\ExempleController;
use App\Http\Controllers\BackOfficeController\DemandecollecteController;
use App\Http\Controllers\BackOfficeController\AnnonceDechetsController;
use App\Http\Controllers\FrontOfficeController\HomeController;

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

// Prefix pour le backOffice : 
Route::prefix('back')->group(function () {



Route::resource('annoncedechets', AnnonceDechetsController::class)->names([
    'index' => 'AnnonceDechet.index',
    'create' => 'AnnonceDechet.create',
    'store' => 'AnnonceDechet.store',
    'edit' => 'AnnonceDechet.edit',
    'update' => 'AnnonceDechet.update',
]);
Route::get('annoncedechets/{id}', [AnnonceDechetsController::class, 'show'])->name('AnnonceDechet.show');
Route::delete('annoncedechets/{id}', [AnnonceDechetsController::class, 'destroy'])->name('AnnonceDechet.destroy');
Route::get('/annoncedechets/create', [AnnonceDechetsController::class, 'create'])->name('AnnonceDechet.create');
Route::get('/annoncedechets/{id}/payed', [AnnonceDechetsController::class, 'payed'])->name('AnnonceDechet.payed');


    Route::get('/dashboard', [DashboardControllerB::class, 'index'])->name('dashboard');
    Route::get('/exemple', [ExempleController::class, 'index'])->name('exemple.index');
});

// Prefix pour le frontOffice : 
Route::prefix('front')->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    // Vous pouvez ajouter d'autres routes liées au front-office ici
});
