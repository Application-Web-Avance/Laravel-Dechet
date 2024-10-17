<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BackOfficeController\DashboardControllerB;
use App\Http\Controllers\BackOfficeController\ExempleController;
use App\Http\Controllers\FrontOfficeController\HomeController;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

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
    Route::get('/home', [HomeController::class, 'index']);
    // Vous pouvez ajouter d'autres routes liées au front-office ici
});

Route::resource('abonnement', AbonnementController::class);

