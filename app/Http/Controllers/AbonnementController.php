<?php

namespace App\Http\Controllers;

use App\Models\Abonnement;
use App\Models\PlanAbonnement;
use Illuminate\Http\Request;
use App\Models\User;
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
        $data = $request->validate([
            'plan_abonnement_id' => 'required|exists:plan_abonnement,id', // Validate the plan_abonnement_id exists
            'user_id' => 'required|exists:users,id', // Validate the user_id exists
            'date_debut' => 'required|date',
            'image' => 'nullable|image',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('images/abonnement', 'public');
        }

        // Create the abonnement for the selected user
        $planAbonnement = PlanAbonnement::findOrFail($data['plan_abonnement_id']);
        $abonnement = $planAbonnement->abonnement()->create($data);

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
        // You can add more fields like 'date_fin' or price if needed
    ]);

    return redirect()->back()->with('success', 'You have successfully subscribed to the ' . $plan->type . ' plan.');
}

}
