<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BackOfficeController\DashboardControllerB;
use App\Http\Controllers\BackOfficeController\ExempleController;
use App\Http\Controllers\FrontOfficeController\HomeController;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;
use App\Http\Controllers\AbonnementController;
use App\Http\Controllers\PlanAbonnementController;

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
Route::resource('/abonnement', AbonnementController::class);
Route::resource('/planabonnement', PlanAbonnementController::class);
});

//Prefix pour le frontOffice :
Route::prefix('front')->group(function () {
    Route::get('/home', [HomeController::class, 'index']);
    Route::get('/plans', [PlanAbonnementController::class, 'showPlansFront']);

});


