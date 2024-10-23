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


// Prefix pour le backOffice :
Route::prefix('back')->middleware('auth')->group(function () { // Ajoutez votre middleware ici
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

    //admin CRUD
    Route::get('/usersV', [AdminController::class, 'getUsersVerified'])->name('usersA.index');

    Route::post('/users/{id}/accept', [AdminController::class, 'accept'])->name('users.accept');
    Route::post('/users/{id}/reject', [AdminController::class, 'reject'])->name('users.reject');

    Route::get('/centres', [CentreDeRecyclageController::class, 'getUsersVerified'])->name('centres.index');
    Route::get('/centres/type-dechet', [TypeDechetsController::class, 'getUsersVerified'])->name('type-dechets');
    Route::delete('/centres/{id}', [CentreDeRecyclageController::class, 'destroy'])->name('centres.destroy');
    Route::get('/centres/create', [CentreDeRecyclageController::class, 'create'])->name('centres.create');
    Route::post('/centres', [CentreDeRecyclageController::class, 'store'])->name('centres.store');
    Route::post('/back/centres/type-dechet', [TypeDechetsController::class, 'store'])->name('type-dechets.store');
    Route::get('/centres/{id}', [CentreDeRecyclageController::class, 'edit'])->name('centres.edit');
    Route::put('/centres/{id}', [CentreDeRecyclageController::class, 'update'])->name('centres.update');



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

    //admin CRUD
    Route::get('/usersV', [AdminController::class, 'getUsersVerified'])->name('usersA.index');
    Route::post('/users/{id}/accept', [AdminController::class, 'accept'])->name('users.accept');
    Route::post('/users/{id}/reject', [AdminController::class, 'reject'])->name('users.reject');



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
Route::post('/test/{id}', [AnnonceDechetsController::class, 'test'])->name('AnnonceDechet.test');
Route::get('/success/{id}', [AnnonceDechetsController::class, 'paymentSuccess'])->name('AnnonceDechet.success');
Route::get('/download-receipt/{paymentId}', [PaymentDechetController::class, 'downloadReceipt'])->name('payment.receipt');
Route::get('/historique-paiements', [PaymentDechetController::class, 'historiquePaiements'])->name('historique.paiements');




   Route::get('/paymentdechet', [PaymentDechetController::class, 'index'])->name('paymentdechet.index');
    Route::get('/paymentdechet/{id}', [PaymentDechetController::class, 'show'])->name('paymentdechet.show');


});



// Prefix pour le frontOffice :
Route::prefix('front')->middleware('auth')->group(function () {
    Route::get('/home', [DashboardControllerF::class, 'index'])->name('FrontHome');

    // Fonction pour Participant
    Route::get('/evenement', [ParticipantController::class, 'getAllCollectDechet'])->name('evenementFront.index');
    Route::post('/evenement/{eventId}/participer', [ParticipantController::class, 'participer'])->name('evenementFront.participer');
    Route::get('/participant', [ParticipantController::class, 'getEventsById'])->name('evenementFront.myEvents');
    Route::delete('/participant/{id}', [ParticipantController::class, 'supprimerParti'])->name('evenementFront.supprimer');
    Route::get('/evenement/proches', [ParticipantController::class, 'getCollectDechetProche'])->name('evenement.proches');


});

    Route::get('/centres', [CentreDeRecyclageController::class, 'front'])->name('centres.front');


// Access denied page :
Route::get('/denied', function () {
    return view('AccessDenied');
})->name('AccessDenied');



/********************User roots*************************/
// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home'); // Example home route

// Authentication Routes
Route::middleware('guest')->group(function () { // Middleware pour vérifier si l'utilisateur est un invité
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store']);

    Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('/register', [RegisteredUserController::class, 'store']);
// Prefix pour le frontOffice :
Route::prefix('front')->middleware('auth')->group(function () {
    Route::get('/home', [DashboardControllerF::class, 'index'])->name('FrontHome');

    // Fonction pour Participant
    Route::get('/evenement', [ParticipantController::class, 'getAllCollectDechet'])->name('evenementFront.index');
    Route::post('/evenement/{eventId}/participer', [ParticipantController::class, 'participer'])->name('evenementFront.participer');
    Route::get('/participant', [ParticipantController::class, 'getEventsById'])->name('evenementFront.myEvents');
    Route::delete('/participant/{id}', [ParticipantController::class, 'supprimerParti'])->name('evenementFront.supprimer');
});

// Access denied page :
Route::get('/denied', function () {
    return view('AccessDenied');
})->name('AccessDenied');
// Password Reset Routes
Route::get('/forgot-password', [PasswordResetLinkController::class, 'create'])->name('password.request');
Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])->name('password.email');
Route::get('/reset-password/{token}', [NewPasswordController::class, 'create'])->name('password.reset');
Route::post('/reset-password', [NewPasswordController::class, 'store'])->name('password.update');

// Confirm Password Routes
Route::get('/user/confirm-password', [ConfirmablePasswordController::class, 'show'])->name('password.confirm');
Route::post('/user/confirm-password', [ConfirmablePasswordController::class, 'store']);

// Two Factor Authentication Routes
Route::get('/two-factor-challenge', [TwoFactorAuthenticatedSessionController::class, 'index'])->name('two-factor.login');
Route::post('/two-factor-challenge', [TwoFactorAuthenticatedSessionController::class, 'store']);

// Profile Management Routes
Route::get('/user/profile', [UserProfileController::class, 'show'])->name('profile.show');
Route::put('/user/profile-information', [UserProfileController::class, 'update'])->name('profile.update');
Route::put('/user/password', [PasswordController::class, 'update'])->name('user.password.update');


/********************User roots*************************/
// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home'); // Example home route

// Authentication Routes
Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'store']);
Route::get('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

// Registration Routes
Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
Route::post('/register', [RegisteredUserController::class, 'store']);

// Password Reset Routes
Route::get('/forgot-password', [PasswordResetLinkController::class, 'create'])->name('password.request');
Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])->name('password.email');
Route::get('/reset-password/{token}', [NewPasswordController::class, 'create'])->name('password.reset');
Route::post('/reset-password', [NewPasswordController::class, 'store'])->name('password.update');

// Confirm Password Routes
Route::get('/user/confirm-password', [ConfirmablePasswordController::class, 'show'])->name('password.confirm');
Route::post('/user/confirm-password', [ConfirmablePasswordController::class, 'store']);

// Two Factor Authentication Routes
Route::get('/two-factor-challenge', [TwoFactorAuthenticatedSessionController::class, 'index'])->name('two-factor.login');
Route::post('/two-factor-challenge', [TwoFactorAuthenticatedSessionController::class, 'store']);

// Profile Management Routes
Route::get('/user/profile', [UserProfileController::class, 'show'])->name('profile.show');
Route::put('/user/profile-information', [UserProfileController::class, 'update'])->name('profile.update');
Route::put('/user/password', [PasswordController::class, 'update'])->name('user.password.update');
