<?php

namespace App\Http\Controllers\FrontOfficeController;

use Illuminate\Http\Request;
use App\Models\Centrederecyclage;
use App\Models\Entrepriserecyclage;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class EntrepriseController extends Controller
{
    public function indexAll()
    {
        $entreprises = Entrepriserecyclage::all();
        $centres = Centrederecyclage::all(); 
        return view('FrontOffice.gestionEntreprise.index', compact('entreprises', 'centres'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required',
            'specialite' => 'required',
            'numero_siret' => 'required',
            'adresse' => 'required',
            'image_url' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'required',
            //'testimonial' => 'nullable',
        ]);

        if ($request->hasFile('image_url')) {
            // Save the image to 'storage/app/public/entreprises'
            $imagePath = $request->file('image_url')->store('entreprises', 'public');
            $validated['image_url'] = $imagePath; // Save the file path to the DB
        }

        $validated['user_id'] = Auth::id();        
        Entrepriserecyclage::create($validated);
        return redirect()->route('front.entreprise.index')->with('success', 'Entreprise ajoutée avec succès');
    }

    public function update(Request $request, $id){
        
    
    
    $entreprise = Entrepriserecyclage::findOrFail($id); // Use findOrFail to throw a 404 if not found

    
    if ($request->hasFile('image_url')) {
        $imagePath = $request->file('image_url')->store('images', 'public');
        $entreprise->image_url = $imagePath;
    }

    $entreprise->nom = $request->input('nom');
    $entreprise->specialite = $request->input('specialite');
    $entreprise->numero_siret = $request->input('numero_siret');
    $entreprise->adresse = $request->input('adresse');
    $entreprise->description = $request->input('description');

    // Save the updated entreprise
    $entreprise->save();

    // Redirect with success message
    return redirect()->route('front.entreprise.index')->with('success', 'Entreprise mise à jour avec succès');
}



    public function destroy($id)
    {
        // Find the entreprise and delete it
        $entreprise = Entrepriserecyclage::findOrFail($id);
        $entreprise->delete();

        return redirect()->route('front.entreprise.index')->with('success', 'Entreprise supprimée avec succès');
    }


    public function index(Request $request)
    {
        $user = Auth::user();
        $entreprises = $user->entreprise;
        $centres = Centrederecyclage::all();

        return view('FrontOffice.gestionEntreprise.index', compact('entreprises', 'centres'));
    }


    
}
