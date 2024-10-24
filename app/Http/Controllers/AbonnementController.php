<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\Abonnement;
use App\Models\PlanAbonnement;
use Illuminate\Http\Request;
use App\Models\User;
//use App\services\SmsService;
use Twilio\Rest\Client;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use Stripe\Exception\ApiErrorException;
use Stripe\PaymentIntent;
use Twilio\Http\CurlClient;

class AbonnementController extends Controller
{


//    protected $smsService;
//
//    public function __construct(SmsService $smsService)
//    {
//        $this->smsService = $smsService;
//    }



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
    ]);

    // Handle image upload and delete old image if a new one is uploaded
    if ($request->hasFile('image')) {
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

    public function subscribe(Request $request)
{
    // Get the selected plan
    $plan = PlanAbonnement::findOrFail($request->plan_id);
    // Get the authenticated user
    //$user = Auth::user();
    // Check if user already has an active subscription for the same plan

   /* if ($user->abonnements()->where('plan_abonnement_id', $plan->id)->exists()) {
        return redirect()->back()->with('error', 'You are already subscribed to this plan.');
    }*/
    // Create a new Abonnement
    Abonnement::create([
       // 'user_id' => $user->id,
       'user_id' => 1,
        'plan_abonnement_id' => $plan->id,
        'date_debut' => $request->date_debut,
        'image' => $plan->image ,
    ]);

    return redirect()->back()->with('success', 'You have successfully subscribed to the ' . $plan->type . ' plan.');
}

public function test($id, Request $request)
{
    $abonnement = PlanAbonnement::findOrFail($id);
    $userId = Auth::user();; // Replace with the authenticated user ID if needed

    // Store the necessary data in the session to create the subscription later
    session(['plan_id' => $abonnement->id, 'date_debut' => $request->date_debut, 'user_id' => $userId]);

    Stripe::setApiKey(config('stripe.sk'));

    $session = Session::create([
        'line_items' => [
            [
                'price_data' => [
                    'currency' => 'eur',
                    'product_data' => [
                        'name' =>"Subscription Type " .$abonnement->type,
                        'date_debut' => $abonnement->date_debut,
                        'images' => [$abonnement->image && asset('storage/abonnement' . $abonnement->image) ],
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
        // 'user_id' => $user->id,
        'user_id' =>$userId,
         'plan_abonnement_id' => $abonnement->id,
         'date_debut' => $request->date_debut,
         'image' => $abonnement->image ,
         'is_payed' => true ,
     ]);
    return redirect()->away($session->url);
}


public function getSubscriptionStatus()
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
        return response()->json([
            'status' => 'active',
            'plan' => $activeSubscription->planAbonnement->type,
            'start_date' => $activeSubscription->date_debut->format('Y-m-d'),
        ]);
    }

    // Return the trial status if no active subscription
    if ($daysRemaining > 0) {
        return response()->json([
            'status' => 'trial',
            'days_remaining' => $daysRemaining,
        ]);
    }

    // If the trial period has expired and no active subscription
    return response()->json(['status' => 'expired']);
}

public function showNav()
{
    $subscriptionStatus = $this->getSubscriptionStatus(); // Call the function to get status

    // Prepare the subscription status for the view
    $statusData = json_decode($subscriptionStatus->getContent(), true); // Convert JSON response to array

    return view('FrontOffice.LayoutFront.layout', compact('statusData'));
}



}
