<?php

namespace App\Http\Controllers\FrontOfficeController;

use Illuminate\Http\Request;
use App\Models\Contratrecyclage;
use App\Models\Centrederecyclage;
use App\Models\Entrepriserecyclage;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ContractsController extends Controller
{
    
    public function store(Request $request,$id,$id2)
    {
        $validatedData = $request->validate([
            'date_signature' => 'required|date',
            'duree_contract' => 'required|numeric',
            'montant' => 'required|numeric',
            //'typeContract' => 'required|string|max:255',
        ]);

        $validatedData['typeContract']='en cours';
        $validatedData['entreprise_id']=$id;
        $validatedData['centre_id']=$id2;
        // Create new contract
        Contratrecyclage::create($validatedData);

        // Redirect or return with success message
        return redirect()->back()->with('success', 'Contract created successfully.');
    }


    public function index()
    {
        $user = Auth::user();
        $entreprises = $user->entreprise; // Utilisez la relation définie dans le modèle User
        $centres = Centrederecyclage::paginate(2);

        return view('FrontOffice.gestionContract.index', compact('entreprises','centres'));
    }

    public function create($entreprise_id, $centre_id)
    {
        // Retrieve enterprise and center information
        $entreprise = Entrepriserecyclage::findOrFail($entreprise_id);
        $centre = Centrederecyclage::findOrFail($centre_id);

        return view('FrontOffice.gestionContract.create', compact('entreprise', 'centre'));
    }



}
