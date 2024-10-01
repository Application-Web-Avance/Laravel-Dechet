<?php

namespace App\Http\Controllers\FrontOfficeController;

use Illuminate\Http\Request;
use App\Models\Entrepriserecyclage;
use App\Http\Controllers\Controller;

class EntrepriseController extends Controller
{
    public function index()
    {
        $entreprises = Entrepriserecyclage::all();
        return view('FrontOffice.gestionEntreprise.index', compact('entreprises'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required',
            'specialite' => 'required',
            'numero_siret' => 'required',
            'adresse' => 'required',
            'image_url' => 'nullable|image',
            'testimonial' => 'nullable',
        ]);

        if ($request->hasFile('image_url')) {
            $imagePath = $request->file('image_url')->store('entreprises', 'public');
            $validated['image_url'] = $imagePath;
        }

        Entrepriserecyclage::create($validated);

        return redirect()->route('front.entreprise.index')->with('success', 'Entreprise ajoutée avec succès');
    }

    public function update(Request $request, $id)
    {
        // Validate the request
        $request->validate([
            'nom' => 'required|string|max:255',
            'specialite' => 'required|string|max:255',
            'adresse' => 'required|string|max:255',
            'testimonial' => 'nullable|string',
        ]);

        // Find the entreprise and update it
        $entreprise = Entrepriserecyclage::findOrFail($id);
        $entreprise->update($request->all());

        return redirect()->route('front.entreprise.index')->with('success', 'Entreprise mise à jour avec succès');
    }

    public function destroy($id)
    {
        // Find the entreprise and delete it
        $entreprise = Entrepriserecyclage::findOrFail($id);
        $entreprise->delete();

        return redirect()->route('front.entreprise.index')->with('success', 'Entreprise supprimée avec succès');
    }


}
