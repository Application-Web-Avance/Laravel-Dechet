<?php

namespace App\Http\Controllers\BackOfficeController;

use App\Http\Controllers\Controller; 
use App\Models\Demandecollecte;
use App\Models\User;
use App\Models\Entrepriserecyclage;


use Illuminate\Http\Request;

class DemandecollecteController extends Controller
{
    // Afficher tous les enregistrements
    public function index()
    {
        $demandes = Demandecollecte::all();
        return view('demandecollectes.index', compact('demandes'));
    }

    // Afficher le formulaire pour créer un nouvel enregistrement
    public function create()
    {
        $utilisateurs = User::all(); 
        $entreprises = Entrepriserecyclage::all(); 
    
        return view('demandecollectes.create', compact('utilisateurs', 'entreprises'));
    }

    // Enregistrer un nouvel enregistrement
    public function store(Request $request)
    {
        // Validation des données entrantes
        $request->validate([
            'date_demande' => 'required|date',
            'adresse_collecte' => 'required|string|max:255',
            'quantite_totale' => 'required|numeric',
            'description' => 'nullable|string',
            'utilisateur_id' => 'required|exists:users,id',  // Vérifiez que l'ID de l'utilisateur existe
            'entreprise_id' => 'required|exists:entrepriserecyclage,id',  // Vérifiez que l'ID de l'entreprise existe
        ]);
    
        // Création de la demande de collecte
        Demandecollecte::create([
            'date_demande' => $request->date_demande,
            'adresse_collecte' => $request->adresse_collecte,
            'status' => $request->status, 
            'quantite_totale' => $request->quantite_totale,
            'description' => $request->description,
            'utilisateur_id' => $request->utilisateur_id,  // Assurez-vous que cet ID est correctement passé
            'entreprise_id' => $request->entreprise_id,
        ]);
    
        return redirect()->route('demandecollectes.index')->with('success', 'Demande de collecte créée avec succès.');
    }
    
    
    // Afficher un enregistrement spécifique
    public function show(Demandecollecte $demandecollecte)
    {
        return view('demandecollectes.show', compact('demandecollecte'));
    }

    // Afficher le formulaire pour modifier un enregistrement
    public function edit(Demandecollecte $demandecollecte)
    {
        return view('demandecollectes.edit', compact('demandecollecte'));
    }

    // Mettre à jour un enregistrement
    public function update(Request $request, Demandecollecte $demandecollecte)
    {
        $request->validate([
            'date_demande' => 'required|date',
            'status' => 'required|string',
            'adresse_collecte' => 'required|string',
            'description' => 'nullable|string',
            'quantite_totale' => 'required|numeric',
            'utilisateur_id' => 'required|exists:users,id',
            'entreprise_id' => 'nullable|exists:entrepriserecyclage,id',
        ]);

        $demandecollecte->update($request->all());

        return redirect()->route('demandecollectes.index')->with('success', 'Demande de collecte mise à jour avec succès.');
    }

    // Supprimer un enregistrement
    public function destroy(Demandecollecte $demandecollecte)
    {
        $demandecollecte->delete();
        return redirect()->route('demandecollectes.index')->with('success', 'Demande de collecte supprimée avec succès.');
    }
}