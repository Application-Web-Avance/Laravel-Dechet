<?php

namespace App\Http\Controllers\BackOfficeController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AnnonceDechet;
use App\Models\User;


class AnnonceDechetsController extends Controller
{
    public function index()
    {
       // $annonces = AnnonceDechet::paginate(10); 
        $annonces = AnnonceDechet::all();
        return view('AnnonceDechet.index', compact('annonces'));
    }

    public function payed($id)
    {
        $annonce = AnnonceDechet::find($id);

        return view('AnnonceDechet.payed', compact('annonce'));
    
    
    }

    public function create()

    {
        $utilisateurs = User::all(); 
    
        return view('AnnonceDechet.create',compact('utilisateurs'));
    }

  
    public function store(Request $request)
    {
        // Valider les données du formulaire
        $request->validate([
            'utilisateur_id' => 'required',
            'date_demande' => 'required|date',
            'type_dechet' => 'required|string',
            'adresse_collecte' => 'required|string',
            'quantite_totale' => 'required|numeric',
            'price' => 'required|numeric',
            'image' => 'nullable|image|max:2048',
        ]);
    
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('annonces', 'public');
            \Log::info('Image path: ' . $imagePath); 
        }
    
        AnnonceDechet::create([
            'utilisateur_id' => $request->input('utilisateur_id'),
            'date_demande' => $request->input('date_demande'),
            'type_dechet' => $request->input('type_dechet'),
            'status' => 'disponible',
            'adresse_collecte' => $request->input('adresse_collecte'),
            'description' => $request->input('description'),
            'quantite_totale' => $request->input('quantite_totale'),
            'price' => $request->input('price'),
            'image' => $imagePath, 
        ]);
    
        return redirect()->route('AnnonceDechet.index')->with('success', 'Annonce créée avec succès.');
    }

    
   public function show($id)
   {
       $annonce = AnnonceDechet::find($id);
   
       if (!$annonce) {
           return redirect()->route('AnnonceDechet.index')->with('error', 'Annonce introuvable');
       }
   
       return view('AnnonceDechet.show', compact('annonce'));
   }
   

   
    public function edit(AnnonceDechet $annoncedechet)
    {
        return view('AnnonceDechet.edit', compact('annoncedechet'));
    }
    

    public function update(Request $request, AnnonceDechet $annoncedechet)
    {
        $request->validate([
            'status' => 'required',
            'description' => 'required',
            'quantite_totale' => 'required|numeric',
            'price' => 'required|numeric',
            'date_demande' => 'required|date',
            'adresse_collecte' => 'required',
        ]);
    
        $annoncedechet->update($request->all());
    
        return redirect()->route('AnnonceDechet.index')->with('success', 'Annonce mise à jour avec succès.');
    }
    

    public function destroy($id)
{
    $annonce = AnnonceDechet::findOrFail($id);

    $annonce->delete();

    return redirect()->route('AnnonceDechet.index')->with('success', 'Annonce supprimée avec succès.');
}

}
