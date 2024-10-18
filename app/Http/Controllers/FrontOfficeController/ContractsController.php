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
            'pdf_proof' => 'required|mimes:pdf|max:2048',
        ]);

        $validatedData['typeContract']='en cours';
        $validatedData['entreprise_id']=$id;
        $validatedData['centre_id']=$id2;

        if ($request->hasFile('pdf_proof')) {
            $pdfPath = $request->file('pdf_proof')->store('contracts_proofs', 'public'); // Save PDF in storage/app/public/contracts_proofs
            $validatedData['pdf_proof'] = $pdfPath;
        }
        Contratrecyclage::create($validatedData);

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
