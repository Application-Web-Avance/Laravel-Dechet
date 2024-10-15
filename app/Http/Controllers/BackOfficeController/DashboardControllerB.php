<?php

namespace App\Http\Controllers\BackOfficeController;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Collectedechets;
use App\Models\Typedechets;

class DashboardControllerB extends Controller
{
    public function index()
    {
        // $table->enum('role', ['Responsable_Centre', 'Responsable_Entreprise', 'admin', 'user','verifier'])->default('user'); // Champ pour le rôle

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

            // dd($topTypesDechets);
            // Préparer les données pour le graphique
            $labels = $topTypesDechets->pluck('typeDeDechet.type')->toArray(); // Obtenir les noms des types de déchets
            $data = $topTypesDechets->pluck('occurrences')->toArray(); // Obtenir les occurrences

            // Retourner les données à la vue
            return view('BackOffice/dashboard/dashboard', compact(
                'nbUserRoleCentre',
                'nbUserRoleEntreprise',
                'nbUserSimple',
                'nbTotalUsers',
                'nbTotalEventsByEntreprise',
                'nbTotalEventsByCentre',
                'labels',
                'data',
            ));
        }


        // if (Auth::user()->role == 'Responsable_Centre') {

        // }


        return view('BackOffice/dashboard/dashboard');
    }
}
