<?php

namespace App\Http\Controllers\BackOfficeController;

use App\Http\Controllers\Controller;
use App\Models\Collectedechets;
use App\Models\Typedechets;
use Flasher\Toastr\Prime\ToastrFactory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class CollectDechetsController extends Controller
{



    // Function to get all records from collectedechets for the authenticated user
    public function getAllCollect()
    {
        // Check if the user is authenticated
        if (Auth::user()->role == 'Responsable_Centre' || Auth::user()->role == 'Responsable_Entreprise') {

            // Get the currently authenticated user
            $user = Auth::user();

        

            // Get the user ID
            $id_user = $user->id;

            // Fetch collects related to the authenticated user, ordered by created_at descending
            $collects = Collectedechets::where('user_id', $id_user)
                ->orderBy('created_at', 'desc') // Organiser par created_at décroissant
                ->paginate(5);

            // Return the view with the collected data
            return view('BackOffice.gestionCollect.index', ['collects' => $collects]);
        } else {
            // If the user is not authenticated, redirect to login or show an error
            return redirect()->route('AccessDenied');
        }
    }


    public function AjouterDechet(Request $request, ToastrFactory $flasher)
    {
        if (Auth::user()->role == 'Responsable_Centre' || Auth::user()->role == 'Responsable_Entreprise') {
            // Validate the request data
            $request->validate([
                'date' => 'required|date_format:Y-m-d\TH:i|after:now',
                'lieu' => 'required|string|max:60',
                'nbparticipant' => 'integer|min:0',
                'Maxnbparticipant' => 'required|integer|min:1|max:100000',
                'description' => 'required|string|max:200',
                'nomEvent' => 'required|string|max:50',
                'type_de_dechet_id' => 'required|exists:typedechets,id',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
            ]);

            // Create new Collectedechets instance
            $collectDechet = new Collectedechets();
            $collectDechet->date = $request->input('date');
            $collectDechet->lieu = $request->input('lieu');
            $collectDechet->nbparticipant = 0;
            $collectDechet->Maxnbparticipant = $request->input('Maxnbparticipant');
            $collectDechet->description = $request->input('description');
            $collectDechet->nomEvent = $request->input('nomEvent');
            $collectDechet->type_de_dechet_id = $request->input('type_de_dechet_id');
            $collectDechet->user_id = Auth::id();

            // Check if an image is uploaded
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('images/collectes', 'public');
                $collectDechet->image = $imagePath;
            }

            // Save in the database
            $collectDechet->save();

            // Flash a success notification
            // $flasher->addSuccess('Collect Dechet ajouté avec succès!');

            return redirect()->route('evenement.index')->with('success', 'L\'événement a été ajoutée avec succès !');;
        } else {
            return redirect()->route('AccessDenied');
        }
    }




    public function createEvent()
    {
        // Check if the user has the required role
        if (Auth::user()->role == 'Responsable_Centre' || Auth::user()->role == 'Responsable_Entreprise') {

            // Get all types of waste
            $typesDeDechets = Typedechets::all();

            // Pass the data to the view
            return view('backOffice.gestionCollect.create', compact('typesDeDechets'));
        } else {
            return redirect()->route('AccessDenied');
        }
    }
    // Method to edit an event
    public function edit($id)
    {
        // Check if the user has the required role
        if (Auth::user()->role == 'Responsable_Centre' || Auth::user()->role == 'Responsable_Entreprise') {

            $collect = Collectedechets::where('id', $id)
                ->where('user_id', Auth::id()) // Ensure the user can only edit their own records
                ->firstOrFail();

            $typesDeDechets = Typedechets::all();
            return view('BackOffice.gestionCollect.edit', compact('collect', 'typesDeDechets'));
        } else {
            return redirect()->route('AccessDenied');
        }
    }

    // Method to delete an event
    public function destroy($id)
    {
        // Check if the user has the required role
        if (Auth::user()->role == 'Responsable_Centre' || Auth::user()->role == 'Responsable_Entreprise') {

            $collect = Collectedechets::where('id', $id)
                ->where('user_id', Auth::id()) // Ensure the user can only delete their own records
                ->firstOrFail();

            $collect->delete();
            // $flasher->addSuccess('Collect Dechet ajouté avec succès!');

            return redirect()->route('evenement.index')->with('success', 'L\'événement a été supprimée avec succès');
        } else {
            return redirect()->route('AccessDenied');
        }
    }

    public function update(Request $request, $id)
    {
        if (Auth::user()->role == 'Responsable_Centre' || Auth::user()->role == 'Responsable_Entreprise') {

            $request->validate([
                'date' => 'required|date_format:Y-m-d\TH:i|after:now',
                'lieu' => 'required|string|max:60',
                'Maxnbparticipant' => 'required|integer|min:1|max:100000',
                'description' => 'required|string|max:200',
                'nomEvent' => 'required|string|max:50', // Validation pour le nom de l'événement
                'type_de_dechet_id' => 'required|exists:typedechets,id',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048' // Valider l'image
            ]);

            // Trouver l'événement par ID, s'assurer qu'il appartient à l'utilisateur authentifié
            $collect = Collectedechets::where('id', $id)
                ->where('user_id', Auth::id())
                ->firstOrFail();

            // Mettre à jour les champs de l'événement
            $collect->date = $request->input('date');
            $collect->lieu = $request->input('lieu');
            $collect->Maxnbparticipant = $request->input('Maxnbparticipant');
            $collect->description = $request->input('description');
            $collect->nomEvent = $request->input('nomEvent'); // Mise à jour du nom de l'événement
            $collect->type_de_dechet_id = $request->input('type_de_dechet_id');

            // Vérifier si une nouvelle image a été téléchargée
            if ($request->hasFile('image')) {
                // Supprimer l'ancienne image (si elle existe)
                if ($collect->image) {
                    Storage::disk('public')->delete($collect->image);
                }

                // Sauvegarder la nouvelle image
                $imagePath = $request->file('image')->store('images/collectes', 'public');
                $collect->image = $imagePath;
            }

            // Sauvegarder l'événement mis à jour
            $collect->save();

            return redirect()->route('evenement.index')->with('success', 'L\'événement a été mis à jour avec succès');
        } else {
            return redirect()->route('AccessDenied');
        }
    }


    public function showParticipants($id)
    {
        // Vérifier si l'utilisateur a le rôle requis
        if (Auth::user()->role == 'Responsable_Centre' || Auth::user()->role == 'Responsable_Entreprise') {
            // Fetch the event by ID
            $event = Collectedechets::findOrFail($id);

            // Fetch participants related to the event with pagination
            // Assuming there's a relationship defined in your Collect model
            $participants = $event->participants()->paginate(10); // Adjust the number as needed

            return view('BackOffice.gestionCollect.participants', compact('event', 'participants'));
        } else {
            return redirect()->route('AccessDenied');
        }
    }

    public function destroyParticipant($eventId, $participantId)
    {
        // Vérifier si l'utilisateur a le rôle requis
        if (Auth::user()->role == 'Responsable_Centre' || Auth::user()->role == 'Responsable_Entreprise') {
            // Find the event
            $event = Collectedechets::findOrFail($eventId);

            // Find the participant associated with the event
            $participant = $event->participants()->where('user_id', $participantId)->first();

            if ($participant) {
                // Delete the participant entry from the pivot table
                $event->participants()->detach($participantId);
                $event->decrement('nbparticipant');
            }

            // Redirect back with a success message
            return redirect()->route('participants.show', $eventId)
                ->with('success', 'Le Participant a été supprimé de l\'événement avec succès');
        } else {
            return redirect()->route('AccessDenied');
        }
    }

    public function show($id)
    {
        $event = Collectedechets::findOrFail($id); // Replace 'Collecte' with your actual model

        return view('BackOffice.gestionCollect.show', compact('event'));
    }
}
