<?php

namespace App\Http\Controllers;

use App\Models\Abonnement;
use App\Models\PlanAbonnement;
use Illuminate\Http\Request;

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
        return view('abonnement.abonnement', compact('abonnement'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
{
    // Fetch all PlanAbonnement records instead of using the variable $abonnement for clarity
    $plans = PlanAbonnement::all();
    return view('abonnement.create', compact('plans')); // Pass 'plans' to the view
}

public function store(Request $request)
{
    $data = $request->validate([
        'plan_abonnement_id' => 'required|exists:plan_abonnement,id', // Validate the plan_abonnement_id exists
        'date_debut' => 'required|date',
        'image' => 'nullable|image',
    ]);

    // Handle image upload
    if ($request->hasFile('image')) {
        $data['image'] = $request->file('image')->store('images/abonnement', 'public');
    }

    // Use the abonnement relationship instead of rooms()
    $planAbonnement = PlanAbonnement::findOrFail($data['plan_abonnement_id']);
    $planAbonnement->abonnement()->create($data);

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
}
