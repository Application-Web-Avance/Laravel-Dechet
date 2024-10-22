<?php

namespace App\Http\Controllers\FrontOfficeController;

use App\Http\Controllers\Controller;
use App\Models\Collectedechets;
use App\Models\Participant;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

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
                ->orderByRaw('CASE WHEN date < ? THEN 1 ELSE 0 END', [Carbon::now()]) // Events in the future come first
                ->orderByRaw('CASE WHEN nbparticipant < Maxnbparticipant THEN 0 ELSE 1 END') // Events with available spots come first
                ->orderBy('created_at', 'desc') // Order by creation date as a secondary criterion
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
        })
            ->orderByRaw('CASE WHEN date < ? THEN 1 ELSE 0 END', [Carbon::now()]) // Events in the future come first
            ->orderByRaw('CASE WHEN nbparticipant < Maxnbparticipant THEN 0 ELSE 1 END') // Events with available spots come first
            ->orderBy('created_at', 'desc')->paginate(4);


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

    public function getCollectDechetProche() {
        if (Auth::user()->role == 'user') {
            $userId = Auth::id();
            $userAddress = Auth::user()->adresse;

            // Bing Maps API Key
            $apiKey = "AtL9AIZCzKARqxrYW_72bgOmobLAWPfkJMxT0AuJZVqhFGBOORjdSiVg2Wvnn0Qp";

            try {
                // Step 1: Get user's coordinates from their address using Bing Maps API
                $userGeocodingUrl = "http://dev.virtualearth.net/REST/v1/Locations?query=" . urlencode($userAddress) . "&key=" . $apiKey;
                $userResponse = Http::get($userGeocodingUrl);

                // Check if the API response contains valid location data
                if (empty($userResponse['resourceSets'][0]['resources'])) {
                    throw new \Exception("Unable to find the user's location.");
                }

                $userLocation = $userResponse['resourceSets'][0]['resources'][0]['point']['coordinates'];

                // Step 2: Retrieve all events and calculate distance to each one
                $events = Collectedechets::with('participants')->get();

                // Calculate distances for each event
                $eventsWithDistances = $events->map(function ($event) use ($userLocation, $apiKey) {
                    // Get event's address (lieu)
                    $eventAddress = $event->lieu;

                    // Get event's coordinates from its address using Bing Maps API
                    $eventGeocodingUrl = "http://dev.virtualearth.net/REST/v1/Locations?query=" . urlencode($eventAddress) . "&key=" . $apiKey;
                    $eventResponse = Http::get($eventGeocodingUrl);

                    // Check if the API response contains valid location data for the event
                    if (empty($eventResponse['resourceSets'][0]['resources'])) {
                        // If geocoding fails, assign a large default distance and log a warning
                        Log::warning("Unable to find the event location for: " . $eventAddress);
                        $event->distance = 999999; // Assign a large distance to push it to the end
                    } else {
                        $eventLocation = $eventResponse['resourceSets'][0]['resources'][0]['point']['coordinates'];

                        // Calculate distance between user's location and event's location
                        $event->distance = sqrt(
                            pow($eventLocation[0] - $userLocation[0], 2) + pow($eventLocation[1] - $userLocation[1], 2)
                        );
                    }

                    return $event; // Return the modified event model
                });

                // Sort events by distance
                $eventsWithDistances = $eventsWithDistances->sortBy('distance')->values();

                // Step 4: Paginate the sorted events (manual pagination)
                $currentPage = LengthAwarePaginator::resolveCurrentPage();
                $perPage = 6;
                $currentItems = $eventsWithDistances->slice(($currentPage - 1) * $perPage, $perPage)->all();
                $paginatedEvents = new LengthAwarePaginator($currentItems, $eventsWithDistances->count(), $perPage, $currentPage, [
                    'path' => LengthAwarePaginator::resolveCurrentPath(),
                ]);

                // Array to store participation status
                $variablePourDisabledButton = [];
                foreach ($paginatedEvents as $event) {
                    $isParticipated = $event->participants()->where('user_id', $userId)->exists(); // Use the event instance directly
                    $variablePourDisabledButton[$event->id] = $isParticipated;
                }

                return view('FrontOffice.gestionParticipant.index', [
                    'events' => $paginatedEvents,
                    'variablePourDisabledButton' => $variablePourDisabledButton,
                ]);
            } catch (\Exception $e) {
                // Log the exact error message
                Log::error('Error calculating event distances: ' . $e->getMessage());

                // Handle errors, like API failures
                return back()->withErrors(['error' => 'Failed to calculate event distances: ' . $e->getMessage()]);
            }
        } else {
            return redirect()->route('AccessDenied');
        }
    }

}
