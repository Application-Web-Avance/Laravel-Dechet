<?php

namespace App\Http\Controllers\BackOfficeController;

use App\Http\Controllers\Controller;
use App\Models\AnnonceDechet;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Collectedechets;
use App\Models\PaymentDechet;
use App\Models\Typedechets;

class DashboardControllerB extends Controller
{
    public function index(Request $request)
    {
        // $table->enum('role', ['Responsable_Centre', 'Responsable_Entreprise', 'admin', 'user', 'verifier'])->default('user'); // Champ pour le rôle
        $user = Auth::user();

        // Vérification du rôle de l'utilisateur connecté
        if (Auth::user()->role == 'admin') {

            // Nombre d'utilisateurs ayant le rôle 'Responsable_Centre'
            $nbUserRoleCentre = User::where('role', 'Responsable_Centre')->count();

            // Nombre d'utilisateurs ayant le rôle 'Responsable_Entreprise'
            $nbUserRoleEntreprise = User::where('role', 'Responsable_Entreprise')->count();

            // Nombre d'utilisateurs simples
            $nbUserSimple = User::where('role', 'user')->count();

            // Nombre total d'utilisateurs non administrateurs
            $nbTotalUsers = User::whereNotIn('role', ['admin', 'verifier'])->count();

            // Nombre total d'événements créés par les utilisateurs ayant le rôle 'Responsable_Entreprise'
            $nbTotalEventsByEntreprise = Collectedechets::whereHas('user', function ($query) {
                $query->where('role', 'Responsable_Entreprise');
            })->count();

            // Nombre total d'événements créés par les utilisateurs ayant le rôle 'Responsable_Centre'
            $nbTotalEventsByCentre = Collectedechets::whereHas('user', function ($query) {
                $query->where('role', 'Responsable_Centre');
            })->count();

            $topTypesDechets = Collectedechets::whereHas('user', function ($query) {
                $query->whereIn('role', ['Responsable_Centre', 'Responsable_Entreprise']);
            })
                ->select('type_de_dechet_id') // Utiliser l'ID pour rejoindre avec le modèle Typedechets
                ->selectRaw('count(*) as occurrences') // Compter les occurrences
                ->groupBy('type_de_dechet_id') // Grouper par ID de type de déchet
                ->with('typeDeDechet') // Récupérer le type de déchet lié
                ->orderBy('occurrences', 'desc') // Ordre par occurrences décroissantes
                ->get();

            // Préparer les données pour le graphique
            $labels = $topTypesDechets->pluck('typeDeDechet.type')->toArray(); // Obtenir les noms des types de déchets
            $data = $topTypesDechets->pluck('occurrences')->toArray(); // Obtenir les occurrences

            $annonces = AnnonceDechet::where('utilisateur_id', $user->id)->get();
            $total_annonces = AnnonceDechet::where('utilisateur_id', $user->id)->count();
            $annonces_disponibles = AnnonceDechet::where('status', 'disponible')->count();
            $annonces_en_attente = AnnonceDechet::where('status', 'non disponible')->count();
            $total_paiements = PaymentDechet::where('user_id', $user->id)->sum('price');
            $paiements_effectues = PaymentDechet::where('user_id', $user->id)->where('payment_status', 'paid')->count();
            $paiements_en_attente = PaymentDechet::where('user_id', $user->id)->where('payment_status', 'pending')->count();
            $paiements = PaymentDechet::where('user_id', $user->id)->where('payment_status', 'paid')->get();
            $dates = $paiements->pluck('payment_date')->toArray();
            $paiements_montants = $paiements->pluck('price')->toArray();



            return view('BackOffice/dashboard/dashboard', compact(
                'nbUserRoleCentre',
                'nbUserRoleEntreprise',
                'nbUserSimple',
                'nbTotalUsers',
                'nbTotalEventsByEntreprise',
                'nbTotalEventsByCentre',
                'labels',
                'data','annonces', 'total_paiements', 'paiements_effectues', 'paiements_en_attente', 'dates', 'paiements_montants', 'total_annonces', 'annonces_disponibles', 'annonces_en_attente'
            ));
        }

        // Si l'utilisateur connecté est Responsable_Centre ou Responsable_Entreprise
        if ($user->role == 'Responsable_Centre') {
            $topTypesDechetsUser = Collectedechets::where('user_id', $user->id) // Filtrer par utilisateur connecté
                ->select('type_de_dechet_id') // Utiliser l'ID pour rejoindre avec le modèle Typedechets
                ->selectRaw('count(*) as occurrences') // Compter les occurrences
                ->groupBy('type_de_dechet_id') // Grouper par ID de type de déchet
                ->with('typeDeDechet') // Récupérer le type de déchet lié
                ->orderBy('occurrences', 'desc') // Ordre par occurrences décroissantes
                ->get();

            // Préparer les données pour le graphique
            $labels = $topTypesDechetsUser->pluck('typeDeDechet.type')->toArray(); // Obtenir les noms des types de déchets
            $data = $topTypesDechetsUser->pluck('occurrences')->toArray(); // Obtenir les occurrences


            // Si l'utilisateur est un responsable de centre, récupérer le nombre total de participants pour les événements de son centre
            $totalParticipants = Collectedechets::where('user_id', $user->id) // Filtrer par le centre (user_id responsable du centre)
                ->withCount('participants') // Compter les participants pour chaque collecte de déchets
                ->get()
                ->sum('participants_count');

                $annonces = AnnonceDechet::where('utilisateur_id', $user->id)->get();
                $total_annonces = AnnonceDechet::where('utilisateur_id', $user->id)->count();
                $annonces_disponibles = AnnonceDechet::where('status', 'disponible')->count();
                $annonces_en_attente = AnnonceDechet::where('status', 'non disponible')->count();
                $total_paiements = PaymentDechet::where('user_id', $user->id)->sum('price');
                $paiements_effectues = PaymentDechet::where('user_id', $user->id)->where('payment_status', 'paid')->count();
                $paiements_en_attente = PaymentDechet::where('user_id', $user->id)->where('payment_status', 'pending')->count();
                $paiements = PaymentDechet::where('user_id', $user->id)->where('payment_status', 'paid')->get();
                $dates = $paiements->pluck('payment_date')->toArray();
                $paiements_montants = $paiements->pluck('price')->toArray();
    


            return view('BackOffice/dashboard/dashboard', compact('labels', 'data', 'totalParticipants','annonces', 'total_paiements', 'paiements_effectues', 'paiements_en_attente', 'dates', 'paiements_montants', 'total_annonces', 'annonces_disponibles', 'annonces_en_attente'));
        }

        if ($user->role == 'Responsable_Entreprise') {
            $topTypesDechetsUser = Collectedechets::where('user_id', $user->id) // Filtrer par utilisateur connecté
                ->select('type_de_dechet_id') // Utiliser l'ID pour rejoindre avec le modèle Typedechets
                ->selectRaw('count(*) as occurrences') // Compter les occurrences
                ->groupBy('type_de_dechet_id') // Grouper par ID de type de déchet
                ->with('typeDeDechet') // Récupérer le type de déchet lié
                ->orderBy('occurrences', 'desc') // Ordre par occurrences décroissantes
                ->get();

            // Préparer les données pour le graphique
            $labels = $topTypesDechetsUser->pluck('typeDeDechet.type')->toArray(); // Obtenir les noms des types de déchets
            $data = $topTypesDechetsUser->pluck('occurrences')->toArray(); // Obtenir les occurrences

            // Si l'utilisateur est un responsable de entreprise, récupérer le nombre total de participants pour les événements de son centre
            $totalParticipants = Collectedechets::where('user_id', $user->id) // Filtrer par le centre (user_id responsable du centre)
                ->withCount('participants') // Compter les participants pour chaque collecte de déchets
                ->get()
                ->sum('participants_count');


                $annonces = AnnonceDechet::where('utilisateur_id', $user->id)->get();
                $total_annonces = AnnonceDechet::where('utilisateur_id', $user->id)->count();
                $annonces_disponibles = AnnonceDechet::where('status', 'disponible')->count();
                $annonces_en_attente = AnnonceDechet::where('status', 'non disponible')->count();
                $total_paiements = PaymentDechet::where('user_id', $user->id)->sum('price');
                $paiements_effectues = PaymentDechet::where('user_id', $user->id)->where('payment_status', 'paid')->count();
                $paiements_en_attente = PaymentDechet::where('user_id', $user->id)->where('payment_status', 'pending')->count();
                $paiements = PaymentDechet::where('user_id', $user->id)->where('payment_status', 'paid')->get();
                $dates = $paiements->pluck('payment_date')->toArray();
                $paiements_montants = $paiements->pluck('price')->toArray();
    


            return view('BackOffice/dashboard/dashboard', compact('labels', 'data', 'totalParticipants','annonces', 'total_paiements', 'paiements_effectues', 'paiements_en_attente', 'dates', 'paiements_montants', 'total_annonces', 'annonces_disponibles', 'annonces_en_attente'));
        }

        return view('BackOffice/dashboard/dashboard');
    }
}
