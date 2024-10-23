<?php

namespace App\Http\Controllers\FrontOfficeController;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Contratrecyclage;
use App\Models\Centrederecyclage;
use App\Models\Entrepriserecyclage;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Notifications\ContractReminder;
use Illuminate\Support\Facades\Notification;

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
        $entreprises = $user->entreprise()->with(['contrats.centre'])->get();

        $centres = Centrederecyclage::all();

        $expiringContracts = [];
    
        if (!$entreprises || $entreprises->isEmpty()) {
            \Log::info('No entreprise found for the connected user.');
        } else {
            foreach ($entreprises as $entreprise) {
                $contracts = Contratrecyclage::where('entreprise_id', $entreprise->id)->get();
    
                foreach ($contracts as $contract) {
                    $expirationDate = Carbon::parse($contract->date_signature)->addMonths($contract->duree_contract);
                    $reminderDate = $expirationDate->copy()->subDays(30);
    
                    if (Carbon::now()->between($reminderDate, $expirationDate)) {
                        $expiringContracts[] = [
                            'contract_id' => $contract->id,
                            'entreprise' => $entreprise->nom,
                            'expiration_date' => $expirationDate->toFormattedDateString(),
                            'signature_date' => $contract->date_signature,
                        ];
                    }
                }
            }
        }



        return view('FrontOffice.gestionEntreprise.index', compact('entreprises', 'centres','expiringContracts'));
    }


    public function checkForExpiringContracts()
{
    // Get the connected user
    $user = Auth::user();

    // Check if the user has an associated entreprise (might be multiple)
    $entreprises = $user->entreprise;

    if (!$entreprises || $entreprises->isEmpty()) {
        \Log::info('No entreprise found for the connected user.');
        return;
    }

    // Loop through each entreprise the user is responsible for
    foreach ($entreprises as $entreprise) {
        // Fetch the contracts related to the current entreprise
        $contracts = Contratrecyclage::where('entreprise_id', $entreprise->id)->get();

        foreach ($contracts as $contract) {
            // Calculate the expiration date
            $expirationDate = Carbon::parse($contract->date_signature)->addMonths($contract->duree_contract);

            // Calculate the date 30 days before expiration
            $reminderDate = $expirationDate->copy()->subDays(30);

            // Check if the current date is within the next 30 days to expiration
            if (Carbon::now()->between($reminderDate, $expirationDate)) {
                // Ensure the user has an email
                if ($user && $user->email) {
                    // Send the email directly using the Mail facade
                    /*Mail::html("
                        <p>Hello {$user->name},</p>
                        <p>Your contract signed on {$contract->date_signature} is expiring on {$expirationDate->toFormattedDateString()}.</p>
                        <p>Please review the contract at the following link: <a href='".url('/contracts/'.$contract->id)."'>Review Contract</a></p>
                        <p>Thank you for using our service!</p>
                    ", function ($message) use ($user) {
                        $message->to($user->email)
                            ->subject('Contract Expiration Reminder');
                    });*/

                }
            }
        }
    }
}


    
}
