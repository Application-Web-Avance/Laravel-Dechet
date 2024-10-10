<?php

use App\Http\Controllers\BackOfficeController\CollectDechetsController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BackOfficeController\DashboardControllerB;
use App\Http\Controllers\BackOfficeController\ExempleController;
use App\Http\Controllers\FrontOfficeController\HomeController;
use App\Http\Controllers\FrontOfficeController\ParticipantController;
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
//on utilise -> name Utilisation de name pour définir les routes dans les vues exemple <a href="{{ route('evenement.create') }}">Créer un Événement</a>

// Prefix pour le backOffice : 
Route::prefix('back')->group(function () {
    Route::get('/dashboard', [DashboardControllerB::class, 'index'])->name('dashboard');
    Route::get('/exemple', [ExempleController::class, 'index']);

    // Fonction CRUD pour CollectDechets
    Route::get('/evenement', [CollectDechetsController::class, 'getAllCollect'])->name('evenement.index');
    Route::get('/evenement/create', [CollectDechetsController::class, 'createEvent'])->name('evenement.create');
    Route::post('/evenement/store', [CollectDechetsController::class, 'AjouterDechet'])->name('evenement.store');
    Route::get('/evenement/{id}/edit', [CollectDechetsController::class, 'edit'])->name('evenement.edit');
    Route::delete('/evenement/{id}', [CollectDechetsController::class, 'destroy'])->name('evenement.destroy');
    Route::put('/evenement/{id}', [CollectDechetsController::class, 'update'])->name('evenement.update');
    Route::get('/evenement/{id}/participants', [CollectDechetsController::class, 'showParticipants'])->name('participants.show');
    Route::delete('/evenement/{eventId}/participants/{participantId}', [CollectDechetsController::class, 'destroyParticipant'])->name('participants.destroy');
    Route::get('/evenement/{id}', [CollectDechetsController::class, 'show'])->name('evenement.show');
});


// Prefix pour le frontOffice : 
Route::prefix('front')->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('FrontHome');

    // Fonction pour Participant
    Route::get('/evenement', [ParticipantController::class, 'getAllCollectDechet'])->name('evenementFront.index');
    Route::post('/evenement/{eventId}/participer', [ParticipantController::class, 'participer'])->name('evenementFront.participer');
    Route::get('/participant', [ParticipantController::class, 'getEventsById'])->name('evenementFront.myEvents');
    Route::delete('/participant/{id}', [ParticipantController::class, 'supprimerParti'])->name('evenementFront.supprimer');
});



//access denied page :
Route::get('/denied', function () {
    return view('AccessDenied');
})->name('AccessDenied');
