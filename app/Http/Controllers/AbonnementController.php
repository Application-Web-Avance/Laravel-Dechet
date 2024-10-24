<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\Abonnement;
use App\Models\PlanAbonnement;
use App\Http\Controllers\PlanAbonnementController;
use Illuminate\Http\Request;
use App\Models\User;
//use App\services\SmsService;
use Twilio\Rest\Client;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use Stripe\Exception\ApiErrorException;
use Stripe\PaymentIntent;
use Twilio\Http\CurlClient;
use Carbon\Carbon;

class AbonnementController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $abonnement = Abonnement::with('PlanAbonnement')->get();
        $abonnement = Abonnement::with(['planAbonnement', 'user'])->get();

        return view('abonnement.abonnement', compact('abonnement'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Fetch all PlanAbonnement records and Users
        $plans = PlanAbonnement::all();
        $users = User::all(); // Fetch all users

        return view('abonnement.create', compact('plans', 'users')); // Pass 'plans' and 'users' to the view
    }


    public function store(Request $request)
    {
        // Validate the incoming data
        $data = $request->validate([
            'plan_abonnement_id' => 'required|exists:plan_abonnement,id',
            'user_id' => 'required|exists:users,id',
            'date_debut' => 'required|date',
            'image' => 'nullable|image',
        ], [
            'plan_abonnement_id.required' => 'Please select a plan abonnement.',
            'plan_abonnement_id.exists' => 'The selected plan abonnement is invalid.',
            'user_id.required' => 'Please select a user.',
            'user_id.exists' => 'The selected user is invalid.',
            'date_debut.required' => 'The start date is required.',
            'date_debut.date' => 'The start date must be a valid date.',
            'image.image' => 'The uploaded file must be an image.',
        ]);

        // Fetch the associated PlanAbonnement
        $planAbonnement = PlanAbonnement::findOrFail($data['plan_abonnement_id']);

        // Check if the request has an image
        if ($request->hasFile('image')) {
            // Store the uploaded image and set it in $data
            $data['image'] = $request->file('image')->store('images/abonnement', 'public');
        } else {
            // If no image is provided, use the PlanAbonnement image
            $data['image'] = $planAbonnement->image ?? null;  // Ensure the PlanAbonnement image is used
        }

        // Create the Abonnement with the data
        $abonnement = Abonnement::create($data);

        return redirect()->route('abonnement.index')->with('success', 'Abonnement created successfully.');
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Abonnement  $abonnement
     * @return \Illuminate\Http\Response
     */
    public function show(Abonnement $abonnement)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Abonnement  $abonnement
     * @return \Illuminate\Http\Response
     */
    public function edit(Abonnement $abonnement)
{
    $plans = PlanAbonnement::all();
    return view('abonnement.edit', compact('plans', 'abonnement'));
}


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Abonnement  $abonnement
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Abonnement $abonnement)
    {
        $data = $request->validate([
            'plan_abonnement_id' => 'required|exists:plan_abonnement,id',
            'date_debut' => 'required|date',
            'image' => 'nullable|image',
        ], [
            'plan_abonnement_id.required' => 'Please select a subscription plan.',
            'plan_abonnement_id.exists' => 'The selected plan is invalid.',
            'date_debut.required' => 'Please provide a start date.',
            'date_debut.date' => 'The start date must be a valid date.',
            'image.image' => 'The uploaded file must be an image.',
        ]);

        // Handle image upload and delete old image if a new one is uploaded
        if ($request->hasFile('image')) {
            // Store the new image
            $data['image'] = $request->file('image')->store('images/abonnement', 'public');
        }

        // Update the abonnement with validated data
        $abonnement->update($data);

        return redirect()->route('abonnement.index')->with('success', 'Abonnement updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Abonnement  $abonnement
     * @return \Illuminate\Http\Response
     */
    public function destroy(Abonnement $abonnement)
    {
        $abonnement->delete();
        return redirect()->route('abonnement.index')->with('success', 'abonnement deleted successfully.');
    }

    public function updateStatus(Abonnement $abonnement)
    {
        // Toggle the 'is_accepted' status
        $abonnement->is_accepted = !$abonnement->is_accepted;
        $abonnement->save();

        // Only proceed if the abonnement is accepted and the user is associated with the abonnement
        if ($abonnement->is_accepted && $abonnement->user) {
            $user = $abonnement->user; // Retrieve the user

//            $message = "Hello " . $user->name . ", your subscription for " . $abonnement->planAbonnement->type . " has been accepted!";
            $sid = config('services.twilio.sid');
            $auth_token = config('services.twilio.auth_token');
            $twilio_phone_number = config('services.twilio.phone_number');
            $user_phone_number = $user->telephone;


            try {
                $twilio = new Client($sid, $auth_token);
                $twilio->setHttpClient(new CurlClient([
                    CURLOPT_SSL_VERIFYPEER => false,
                ]));
                $message = $twilio->messages->create(
                    $user_phone_number,
                    [
                        'from' => $twilio_phone_number,
                        'body' => "Bonjour {$user->name}, votre paiement de {$abonnement->planAbonnement->type} TND a été effectué avec succès. Merci pour votre confiance."
                    ]
                );            } catch (\Exception $e) {
                return redirect()->route('abonnement.index')->with('error', 'Subscription updated, but SMS could not be sent.' . $e->getMessage());
            }
        }

        // Redirect with a success message if the status was updated
        return redirect()->route('abonnement.index')->with('success', 'Abonnement status updated successfully.');
    }


    public function updateBlockedStatus(Request $request, $id)
    {
        // Find the user associated with the abonnement
        $abonnement = Abonnement::findOrFail($id);
        $user = $abonnement->user;

        // Toggle the is_blocked status
        $user->is_blocked = !$user->is_blocked;
        $user->save(); // Save the updated status

        // Redirect back with a success message
        return redirect()->back()->with('success', 'User status updated successfully.');
    }


    public function test($id, Request $request)
    {
        $abonnement = PlanAbonnement::findOrFail($id);
        $userId = Auth::id(); // Get the authenticated user's ID

        // Store the necessary data in the session to create the subscription later
        session(['plan_id' => $abonnement->id, 'date_debut' => $request->date_debut, 'user_id' => $userId]);

        Stripe::setApiKey(config('stripe.sk'));

        $session = Session::create([
            'line_items' => [
                [
                    'price_data' => [
                        'currency' => 'eur',
                        'product_data' => [
                            'name' => "Subscription Type " . $abonnement->type,
                            'images' => [$abonnement->image ? asset('storage/' . $abonnement->image) : null],
                        ],
                        'unit_amount' => $abonnement->price * 100,
                    ],
                    'quantity' => 1,
                ],
            ],
            'mode' => 'payment',
            'success_url' => route('front.showPlans'),
            'cancel_url' => route('subscribe'),
        ]);

        // Create a new Abonnement
        Abonnement::create([
            'user_id' => $userId,
            'plan_abonnement_id' => $abonnement->id,
            'date_debut' => $request->date_debut,
            'image' => $abonnement->image,
            'is_payed' => true,
        ]);

        return redirect()->away($session->url);
    }

    public function getSubscriptionStatus()
    {
        $user = Auth::user();

        // Ensure the user is authenticated
        if (!$user) {
            return ['status' => 'error', 'message' => 'User is not authenticated.'];
        }

        // Calculate the free trial period (30 days from the user's registration date)
        $createdAt = Carbon::parse($user->created_at); // Convert created_at to Carbon instance
        $trialEnd = $createdAt->copy()->addDays(30); // Free trial ends 30 days after registration
        $daysRemainingTrial = $trialEnd->diffInDays(now(), false); // Calculate remaining days (negative if trial expired)

        // Get the user's active subscription
        $activeSubscription = Abonnement::where('user_id', $user->id)->first();

        // Default to not blocked
        $user->is_blocked = false;

        // Case 1: If the user doesn't have an active subscription
        if (!$activeSubscription) {
            if ($daysRemainingTrial > 0) {
                return [
                    'status' => 'trial',
                    'days_remaining' => $daysRemainingTrial,
                    'message' => "Your free trial ends in {$daysRemainingTrial} days.",
                ];
            } else {
                // Free trial has expired; block the user
                $user->is_blocked = true;
                $user->save(); // Persist the change
                return [
                    'status' => 'expired',
                    'message' => 'Your free trial has expired. Your account has been blocked.',
                ];
            }
        }

        // Case 2: User has an abonnement
        $dateDebut = Carbon::parse($activeSubscription->date_debut); // Ensure date_debut is a Carbon instance

        // Subcase 1: If the subscription start date is in the future
        if ($dateDebut > now()) {
            $daysUntilActive = $dateDebut->diffInDays(now()); // Calculate days until abonnement is active

            // Block the user since the free trial has expired
            if ($daysRemainingTrial <= 0) {
                $user->is_blocked = true;
                $user->save(); // Persist the change
                return [
                    'status' => 'pending', // Abonnement will be active soon
                    'message' => "Your abonnement will be active in {$daysUntilActive} days. Your account has been blocked.",
                ];
            }

            return [
                'status' => 'pending', // Abonnement will be active soon
                'message' => "Your abonnement will be active in {$daysUntilActive} days.",
            ];
        }

        // Subcase 2: If the subscription start date is in the past (i.e., already active)
        $planType = $activeSubscription->planAbonnement->type; // Get the subscription plan type
        $durationDays = 0;

        switch ($planType) {
            case 'mensuel':
                $durationDays = 30;
                break;
            case 'trimestriel':
                $durationDays = 90;
                break;
            case 'semestriel':
                $durationDays = 180;
                break;
            case 'annuel':
                $durationDays = 365;
                break;
            default:
                return ['status' => 'error', 'message' => 'Unknown plan type.'];
        }

        // Calculate the subscription end date
        $endDate = $dateDebut->copy()->addDays($durationDays); // Add the plan's duration to the start date
        $daysRemaining = $endDate->diffInDays(now()); // Calculate remaining days until abonnement ends

        // Check if the abonnement has expired
        if ($daysRemaining <= 0) {
            $user->is_blocked = true;
            $user->save(); // Persist the change
            return [
                'status' => 'expired',
                'message' => "Your abonnement has expired. Your account has been blocked.",
            ];
        }

        // If the abonnement is still active, set is_blocked to false
        $user->is_blocked = false;
        $user->save(); // Persist the change

        return [
            'status' => 'active',
            'message' => "Your abonnement will end in {$daysRemaining} days.",
            'plan' => $planType,
        ];
    }


        // Display PlanAbonnement on the front office
        public function showPlansFront()
        {
            $statusData = $this->getSubscriptionStatus();

            // Ensure 'days_remaining' key exists, initialize if not present
            if (empty($statusData) || !isset($statusData['days_remaining'])) {
                $statusData['days_remaining'] = 0; // Default value or any logic you prefer
            }

            $plans = PlanAbonnement::all();
            return view('planAbonnement.abonnementFO', compact('plans', 'statusData'));
        }



}
