<?php

namespace App\Http\Controllers;

use App\Models\PlanAbonnement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PlanAbonnementController extends Controller
{
    // Display a listing of the resource
    public function index()
    {
        $planAbonnement = PlanAbonnement::all();
        return view('planAbonnement.planAbonnement', compact('planAbonnement'));
    }

    // Show the form for creating a new resource
    public function create()
    {
        return view('planAbonnement.create');
    }

    // Store a newly created resource in storage
    public function store(Request $request)
    {
        $data = $request->validate([
            'type' => 'required|string|max:255',
            'price' => 'required|integer|min:1',
            'description' => 'required|string|max:255',
            'image' => 'nullable|image',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('images/abonnement', 'public');
        }

        PlanAbonnement::create($data);

        return redirect()->route('planabonnement.index')
                         ->with('success', 'Plan Abonnement created successfully.');
    }

    // Show the form for editing the specified resource
    public function edit($id)
    {
        $planAbonnement = PlanAbonnement::findOrFail($id);
        return view('planAbonnement.edit', compact('planAbonnement'));
    }

        /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Validate request data
        $data = $request->validate([
            'type' => 'required|string|max:255',
            'price' => 'required|integer|min:1',
            'description' => 'required|string|max:255',
            'image' => 'nullable|image', // Optional image
        ]);

        // Handle image upload and delete the old image if a new one is uploaded
        if ($request->hasFile('image')) {
            // Delete old image from storage if it exists
            if ($planAbonnement->image) {
                Storage::disk('public')->delete($planAbonnement->image);
            }

            // Store the new image and update the image path
            $data['image'] = $request->file('image')->store('images/abonnement', 'public');
        }

        $planAbonnement = PlanAbonnement::where('id', $id);
        $planAbonnement->update($data);

        // Redirect back with success message
        return redirect()->route('planabonnement.index')->with('success', 'Plan Abonnement updated successfully.');
    }

/**
 * Remove the specified resource from storage.
 *
 * @param  int $id
 * @return \Illuminate\Http\Response
 */
    public function destroy($id)
    {

        $planAbonnement = PlanAbonnement::where('id', $id);
        $planAbonnement->delete();

        return redirect()->route('planabonnement.index')
                         ->with('success', 'Plan Abonnement deleted successfully.');
    }
}
