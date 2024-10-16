<?php

use Illuminate\Support\Facades\Route;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;
use App\Http\Controllers\FrontOfficeController\HomeController;
use App\Http\Controllers\BackOfficeController\ExempleController;
use App\Http\Controllers\BackOfficeController\DashboardControllerB;
use App\Http\Controllers\FrontOfficeController\ContractsController;
use App\Http\Controllers\FrontOfficeController\EntrepriseController;

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


// Route::get('/front', function () {
//     return view('front');
// });


//Prefix pour le backOffice : 
Route::prefix('back')->group(function () {
Route::get('/dashboard', [DashboardControllerB::class, 'index']);
Route::get('/exemple', [ExempleController::class, 'index']);

});

//Prefix pour le frontOffice : 
Route::prefix('front')->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('front.home');;
    Route::get('/entreprises', [EntrepriseController::class, 'index'])->name('front.entreprise.index');
    Route::post('/entreprises', [EntrepriseController::class, 'store'])->name('entreprises.store');
    Route::put('/entreprises/{id}', [EntrepriseController::class, 'update'])->name('entreprises.update');
    Route::delete('/entreprises/{id}', [EntrepriseController::class, 'destroy'])->name('entreprises.destroy');
    Route::get('/entreprises/contracts', [ContractsController::class,  'index'])->name('contracts.index');
    Route::get('/entreprises/{entreprise_id}/contracts/{centre_id}/create', [ContractsController::class, 'create'])->name('contracts.create');
    Route::post('/entreprises/contracts/create/{id}/{id2}', [ContractsController::class, 'store'])->name('contracts.store');
});




