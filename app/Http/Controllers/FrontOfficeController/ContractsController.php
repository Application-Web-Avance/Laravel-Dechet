<?php

namespace App\Http\Controllers\FrontOfficeController;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
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

        return redirect()->route('front.entreprise.index')->with('success', 'Contract created successfully.');
    }


    public function index()
{
    $user = Auth::user();
    $entreprises = $user->entreprise; // Use the defined relationship in the User model

    $allCentres = []; // Array to store all centers with duration

    foreach ($entreprises as $entreprise) {
        \Log::info('Entreprise ID : ' . $entreprise->id); // Logging the entreprise ID
        $contracts = Contratrecyclage::where('entreprise_id', $entreprise->id)->get();

        foreach ($contracts as $contract) {
            \Log::info('Contract ID : ' . $contract->id); // Logging the contract ID

            $centre = $contract->centre; // Get the centre relationship directly (should be single)
            if ($centre) {
                // Calculate remaining duration only if the centre exists
                $centre->duree_restante = $centre->dureeRestante($entreprise->id);

                \Log::info('Centre ID : ' . $centre->id);
                \Log::info('Centre Remaining Days : ' . $centre->duree_restante);

                $allCentres[] = $centre; // Add the centre to the array
            } else {
                \Log::warning('No centre found for contract ID: ' . $contract->id);
            }
        }
    }

    // For pagination, converting array to collection before paginating
    $centres = collect($allCentres)->paginate(2);

    return view('FrontOffice.gestionContract.index', compact('entreprises', 'centres'));
}



    public function create($entreprise_id, $centre_id)
    {
        // Retrieve enterprise and center information
        $entreprise = Entrepriserecyclage::findOrFail($entreprise_id);
        $centre = Centrederecyclage::findOrFail($centre_id);

        return view('FrontOffice.gestionContract.create', compact('entreprise', 'centre'));
    }


    public function createContract($entrepriseId, $centreId)
    {
        $entreprise = Entrepriserecyclage::findOrFail($entrepriseId);
        $centre = Centrederecyclage::findOrFail($centreId);
        $user = Auth::user();
        $entreprises = $user->entreprise;
        $expiringContracts = [];
    

            foreach ($entreprises as $entreprisees) {
                $contracts = Contratrecyclage::where('entreprise_id', $entreprisees->id)->get();
    
                foreach ($contracts as $contract) {
                    $expirationDate = Carbon::parse($contract->date_signature)->addMonths($contract->duree_contract);
                    $reminderDate = $expirationDate->copy()->subDays(30);
    
                    if (Carbon::now()->between($reminderDate, $expirationDate)) {
                        $expiringContracts[] = [
                            'contract_id' => $contract->id,
                            'entreprise' => $entreprisees->nom,
                            'expiration_date' => $expirationDate->toFormattedDateString(),
                            'signature_date' => $contract->date_signature,
                        ];
                    }
                }
            }

        return view('FrontOffice.gestionContract.create', compact('entreprise', 'centre','expiringContracts'));
    }

}
