<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BackOfficeController\DashboardControllerB;
use App\Http\Controllers\BackOfficeController\ExempleController;
use App\Http\Controllers\FrontOfficeController\HomeController;
use App\Http\Controllers\AbonnementController;
use App\Http\Controllers\PlanAbonnementController;
use App\Http\Controllers\StripeController;

// Prefix for the backOffice:
Route::prefix('back')->group(function () {
    Route::get('/dashboard', [DashboardControllerB::class, 'index']);
    Route::get('/exemple', [ExempleController::class, 'index']);
    Route::resource('/abonnement', AbonnementController::class);
    Route::resource('/planabonnement', PlanAbonnementController::class);
});

// Prefix for the frontOffice:
Route::prefix('front')->group(function () {
    Route::get('/home', [HomeController::class, 'index']);
    Route::get('/plans', [PlanAbonnementController::class, 'showPlansFront']);

    // Subscription route (change this line)
    Route::post('/subscribe', [AbonnementController::class, 'subscribe'])->name('subscribe'); // This should handle the subscription logic

    // Stripe payment routes
    Route::post('/stripe/payment', [StripeController::class, 'handlePayment'])->name('stripe.payment');

    // Payment success and cancel routes
    Route::get('/payment/success', function () {
        return 'Payment Successful!';
    })->name('payment.success');

    Route::get('/payment/cancel', function () {
        return 'Payment Canceled!';
    })->name('payment.cancel');

    // Webhook route
    Route::post('/stripe/webhook', [StripeController::class, 'handleWebhook'])->name('stripe.webhook');
});
