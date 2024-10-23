<?php

namespace App\Http\Controllers\BackOfficeController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AnnonceDechet;
use App\Models\PaymentDechet;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashboardControllerB extends Controller
{


    public function index()
    {
        $user = Auth::user();

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

            return view('BackOffice/dashboard/dashboard', compact('annonces', 'total_paiements', 'paiements_effectues', 'paiements_en_attente', 'dates', 'paiements_montants', 'total_annonces', 'annonces_disponibles', 'annonces_en_attente'));

    }
}
