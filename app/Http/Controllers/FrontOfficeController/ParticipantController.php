<?php

namespace App\Http\Controllers\FrontOfficeController;

use App\Http\Controllers\Controller;
use App\Models\Collectedechets;
use App\Models\Participant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ParticipantController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getAllCollectDechet()
    {
        if (Auth::user()->role == 'user') {
            $userId = Auth::id();

            // Retrieve all events related to waste collection, paginated by 6
            $events = Collectedechets::with('participants')
                ->orderBy('created_at', 'desc')
                ->paginate(6);

            // Array to store participation status
            $variablePourDisabledButton = [];

            foreach ($events as $event) {
                $isParticipated = $event->participants()->where('user_id', $userId)->exists();
                $variablePourDisabledButton[$event->id] = $isParticipated;
            }

            return view('FrontOffice.gestionParticipant.index', [
                'events' => $events,  // Pass events as is
                'variablePourDisabledButton' => $variablePourDisabledButton,  // Pass participation status
            ]);
        } else {
            return redirect()->route('AccessDenied');
        }
    }





    public function participer(Request $request, $eventId)
    {
        // Get the authenticated user's ID
        $userId = Auth::id();

        // Check if the user has already participated in this event
        if (Participant::where('user_id', $userId)->where('collecte_dechets_id', $eventId)->exists()) {
            return redirect()->route('evenementFront.index')->with('error', 'Vous avez déjà participé à cet événement.');
        }

        // Create a new participant
        Participant::create([
            'user_id' => $userId,
            'collecte_dechets_id' => $eventId,
        ]);

        // Increment the number of participants in the collectedechets table
        $collectedEvent = Collectedechets::find($eventId);
        if ($collectedEvent) {
            $collectedEvent->increment('nbparticipant'); // Increment the nbparticipant column
        }

        // Redirect back or to a specific page with a success message
        return redirect()->route('evenementFront.index')->with('success', 'Vous avez participé à l\'événement avec succès.');
    }



    public function getEventsById()
    {
        // Get the authenticated user's ID
        $userId = Auth::id();

        // Get all events the user has participated in by joining the 'collectedechets' and 'participant' tables
        $events = Collectedechets::whereHas('participants', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })->orderBy('created_at', 'desc')->paginate(4);
        // Return a view to display the events
        return view('FrontOffice.gestionParticipant.participants', ['events' => $events]);
    }

    public function supprimerParti($id)
    {
        // Get the authenticated user's ID
        $userId = Auth::id();

        // Find the participant record with matching user_id and collecte_dechets_id
        $participant = Participant::where('user_id', $userId)
            ->where('collecte_dechets_id', $id) // Assuming $id is collecte_dechets_id
            ->first();
        $participant->delete();

        $event = Collectedechets::find($id);
        $event->decrement('nbparticipant');


          $events = Collectedechets::whereHas('participants', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })->orderBy('created_at', 'desc')->paginate(4);

        return redirect()->route('evenementFront.myEvents', ['events', $events])
            ->with('success', 'Événement a été supprimé avec succès.');
    }
}
