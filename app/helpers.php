<?php
use Illuminate\Support\Facades\Auth;
use App\Models\Abonnement;
use App\Models\PlanAbonnement;
use Illuminate\Http\Request;
use App\Models\User;
use Twilio\Rest\Client;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use Stripe\Exception\ApiErrorException;
use Twilio\Http\CurlClient;

if (!function_exists('getSubscriptionStatus')) {
     function getSubscriptionStatus()
    {
        $user = Auth::user();

        // Calculate the free trial period (30 days from the user's registration date)
        $createdAt = $user->created_at;
        $trialEnd = $createdAt->copy()->addMonth(); // Adds 1 month (30 days) to the registration date
        $daysRemaining = $trialEnd->diffInDays(now(), false); // Calculate remaining days (negative if trial expired)

        // Get the user's active subscription
        $activeSubscription = Abonnement::where('user_id', $user->id)
            ->where('date_debut', '<=', now()) // Subscription has started
            ->first();

        // If there's an active subscription
        if ($activeSubscription) {
            return [
                'status' => 'active',
                'plan' => $activeSubscription->planAbonnement->type,
                'start_date' => $activeSubscription->date_debut->format('Y-m-d'),
            ];
        }

        // Return the trial status if no active subscription
        if ($daysRemaining > 0) {
            return [
                'status' => 'trial',
                'days_remaining' => $daysRemaining,
            ];
        }

        // If the trial period has expired and no active subscription
        return ['status' => 'expired'];
    }
}
