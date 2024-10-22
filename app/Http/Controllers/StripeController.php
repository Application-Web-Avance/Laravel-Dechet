<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Checkout\Session;
use Stripe\Stripe;
use Illuminate\Support\Facades\Log;

class StripeController extends Controller
{
    // Handle the payment and create a Stripe Checkout session
    public function handlePayment(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'plan_id' => 'required|integer',
            'price' => 'required|numeric|min:1',
            'date_debut' => 'required|date',
        ]);

        Stripe::setApiKey(config('services.stripe.secret'));

        // Create a new Stripe Checkout Session
        try {
            $checkoutSession = Session::create([
                'payment_method_types' => ['card'],
                'line_items' => [[
                    'price_data' => [
                        'currency' => 'usd',
                        'product_data' => [
                            'name' => 'Subscription Plan #' . $request->plan_id,
                        ],
                        'unit_amount' => $request->price * 100,  // Convert to cents
                    ],
                    'quantity' => 1,
                ]],
                'mode' => 'payment',
                'success_url' => route('payment.success', ['plan_id' => $request->plan_id, 'date_debut' => $request->date_debut]),
                'cancel_url' => route('payment.cancel'),
            ]);

            return response()->json(['id' => $checkoutSession->id]);

        } catch (\Exception $e) {
            Log::error('Stripe Checkout Session Error: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to create Stripe session'], 500);
        }
    }

    // Handle Stripe webhook events (e.g., payment success)
    public function handleWebhook(Request $request)
    {
        // Retrieve the raw body content of the webhook event
        $payload = @file_get_contents('php://input');
        $event = null;

        try {
            // Parse the event using Stripe's library
            $event = \Stripe\Event::constructFrom(
                json_decode($payload, true)
            );
        } catch (\UnexpectedValueException $e) {
            // Invalid payload
            Log::error('Invalid Stripe webhook payload');
            return response()->json(['error' => 'Invalid payload'], 400);
        }

        // Handle the event types you are interested in
        switch ($event->type) {
            case 'checkout.session.completed':
                // The payment was successful, handle your post-payment logic here
                $session = $event->data->object;

                // You can retrieve session.customer and session.amount_total for further processing
                Log::info('Payment was successful for session: ' . $session->id);

                // Mark the subscription as active or handle any post-payment logic
                // e.g., save in your database, send a confirmation email, etc.

                break;

            default:
                Log::warning('Received unknown event type ' . $event->type);
        }

        // Return a response to acknowledge receipt of the event
        return response()->json(['status' => 'success']);
    }

    public function paymentSuccess(Request $request)
{
    // Here, you can create the subscription in your database using the passed data
    $planId = $request->get('plan_id');
    $dateDebut = $request->get('date_debut');

    // You might want to pass the authenticated user's ID
    $userId = 1; // Replace with the actual authenticated user's ID

    // Store the subscription in the database
    Abonnement::create([
        'user_id' => $userId,
        'plan_abonnement_id' => $planId,
        'date_debut' => $dateDebut,
    ]);

    return view('payment.success'); // Create a view for successful payment
}

}
