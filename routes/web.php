<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\BackOfficeController\CentreDeRecyclageController;
use App\Http\Controllers\BackOfficeController\CollectDechetsController;
use App\Http\Controllers\BackOfficeController\TypeDechetsController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BackOfficeController\DashboardControllerB;
use App\Http\Controllers\BackOfficeController\ExempleController;
use App\Http\Controllers\FrontOfficeController\DashboardControllerF;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\FrontOfficeController\ParticipantController;
use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;
use Laravel\Fortify\Http\Controllers\ConfirmablePasswordController;
use Laravel\Fortify\Http\Controllers\NewPasswordController;
use Laravel\Fortify\Http\Controllers\PasswordController;
use Laravel\Fortify\Http\Controllers\PasswordResetLinkController;
use Laravel\Fortify\Http\Controllers\RegisteredUserController;
use Laravel\Fortify\Http\Controllers\TwoFactorAuthenticatedSessionController;
use Laravel\Jetstream\Http\Controllers\Inertia\UserProfileController;
use App\Http\Controllers\BackOfficeController\DemandecollecteController;
use App\Http\Controllers\BackOfficeController\AnnonceDechetsController;
use App\Http\Controllers\BackOfficeController\PaymentDechetController;
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
Route::get('/verifierAuth/{cin}', function ($cin) {
    // Transmettre le paramètre 'cin' à la vue
    return view('verifierAuth', ['cin' => $cin]);
})->name('verifierRoute');


// Prefix for the backOffice:
Route::prefix('back')->middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardControllerB::class, 'index'])->name('dashboard');
    Route::get('/exemple', [ExempleController::class, 'index']);

    // CRUD for CollectDechets
    Route::get('/evenement', [CollectDechetsController::class, 'getAllCollect'])->name('evenement.index');
    Route::get('/evenement/create', [CollectDechetsController::class, 'createEvent'])->name('evenement.create');
    Route::post('/evenement/store', [CollectDechetsController::class, 'AjouterDechet'])->name('evenement.store');
    Route::get('/evenement/{id}/edit', [CollectDechetsController::class, 'edit'])->name('evenement.edit');
    Route::delete('/evenement/{id}', [CollectDechetsController::class, 'destroy'])->name('evenement.destroy');
    Route::put('/evenement/{id}', [CollectDechetsController::class, 'update'])->name('evenement.update');
    Route::get('/evenement/{id}/participants', [CollectDechetsController::class, 'showParticipants'])->name('participants.show');
    Route::delete('/evenement/{eventId}/participants/{participantId}', [CollectDechetsController::class, 'destroyParticipant'])->name('participants.destroy');
    Route::get('/evenement/{id}', [CollectDechetsController::class, 'show'])->name('evenement.show');

    // Admin CRUD
    Route::get('/usersV', [AdminController::class, 'getUsersVerified'])->name('usersA.index');
    Route::post('/users/{id}/accept', [AdminController::class, 'accept'])->name('users.accept');
    Route::post('/users/{id}/reject', [AdminController::class, 'reject'])->name('users.reject');

    // Centres
    Route::get('/centres', [CentreDeRecyclageController::class, 'getUsersVerified'])->name('centres.index');
    Route::delete('/centres/{id}', [CentreDeRecyclageController::class, 'destroy'])->name('centres.destroy');
    Route::get('/centres/create', [CentreDeRecyclageController::class, 'create'])->name('centres.create');
    Route::post('/centres', [CentreDeRecyclageController::class, 'store'])->name('centres.store');
    Route::get('/centres/{id}', [CentreDeRecyclageController::class, 'edit'])->name('centres.edit');
    Route::put('/centres/{id}', [CentreDeRecyclageController::class, 'update'])->name('centres.update');

    // AnnonceDechets CRUD
    Route::resource('annoncedechets', AnnonceDechetsController::class)->names([
        'store' => 'annoncedechets.store',
        'edit' => 'annoncedechets.edit',
        'update' => 'annoncedechets.update',
    ]);
    Route::get('/annoncedechets', [AnnonceDechetsController::class, 'index'])->name('annoncedechets.index');
    Route::get('annoncedechets/{id}', [AnnonceDechetsController::class, 'show'])->name('annoncedechets.show');
    Route::delete('annoncedechets/{id}', [AnnonceDechetsController::class, 'destroy'])->name('annoncedechets.destroy');
    Route::get('/annoncedechets/create', [AnnonceDechetsController::class, 'create'])->name('annoncedechets.create');
    Route::get('/annoncedechets/{id}/payed', [AnnonceDechetsController::class, 'payed'])->name('annoncedechets.payed');
    Route::post('/annoncedechets/{id}/payed', [AnnonceDechetsController::class, 'handlePayment'])->name('annoncedechets.handlePayment');

    Route::get('/checkout/{id}', [AnnonceDechetsController::class, 'checkout'])->name('AnnonceDechet.checkout');
    Route::get('/success/{id}', [AnnonceDechetsController::class, 'paymentSuccess'])->name('AnnonceDechet.success');
    Route::get('/download-receipt/{paymentId}', [PaymentDechetController::class, 'downloadReceipt'])->name('payment.receipt');
    Route::get('/historique-paiements', [PaymentDechetController::class, 'historiquePaiements'])->name('historique.paiements');
    Route::get('/paymentdechet', [PaymentDechetController::class, 'index'])->name('paymentdechet.index');
    Route::get('/paymentdechet/{id}', [PaymentDechetController::class, 'show'])->name('paymentdechet.show');
});

// Prefix for the frontOffice:
Route::prefix('front')->middleware('auth')->group(function () {
    Route::get('/centres', [CentreDeRecyclageController::class, 'front'])->name('centres.front');
    Route::get('/home', [DashboardControllerF::class, 'index'])->name('FrontHome');
    Route::get('/evenement', [ParticipantController::class, 'getAllCollectDechet'])->name('evenementFront.index');
    Route::post('/evenement/{eventId}/participer', [ParticipantController::class, 'participer'])->name('evenementFront.participer');
    Route::get('/participant', [ParticipantController::class, 'getEventsById'])->name('evenementFront.myEvents');
    Route::delete('/participant/{id}', [ParticipantController::class, 'supprimerParti'])->name('evenementFront.supprimer');
    Route::get('/evenement/proches', [ParticipantController::class, 'getCollectDechetProche'])->name('evenement.proches');
});

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store']);
    Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('/register', [RegisteredUserController::class, 'store']);
    Route::get('/forgot-password', [PasswordResetLinkController::class, 'create'])->name('password.request');
    Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])->name('password.email');
    Route::get('/reset-password/{token}', [NewPasswordController::class, 'create'])->name('password.reset');
    Route::post('/reset-password', [NewPasswordController::class, 'store'])->name('password.update');

});

// Logout
Route::get('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
Route::get('/denied', function () {
    return view('AccessDenied');
})->name('AccessDenied');

