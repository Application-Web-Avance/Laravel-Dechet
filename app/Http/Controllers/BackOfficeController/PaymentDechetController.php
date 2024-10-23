<?php

namespace App\Http\Controllers\BackOfficeController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PaymentDechet;
use Illuminate\Support\Facades\Auth;
use App\Models\AnnonceDechet;
use App\Models\User;
use PDF;



class PaymentDechetController extends Controller
{
     public function index(Request $request)
     {
         $user = Auth::user();

         if (!$user) {
             return redirect()->route('login')->with('error', 'Vous devez être connecté pour voir vos paiements.');
         }

         $annonces = AnnonceDechet::where('utilisateur_id', $user->id)->pluck('id');

         $search = $request->input('search');

         $payments = PaymentDechet::whereIn('annonce_dechet_id', $annonces)
             ->where('payment_status', 'paid')
             ->when($search, function($query, $search) {
                 return $query->whereHas('annonceDechet', function($q) use ($search) {
                     $q->where('adresse_collecte', 'LIKE', "%{$search}%")
                       ->orWhere('type_dechet', 'LIKE', "%{$search}%")
                       ->orWhere('price', 'LIKE', "%{$search}%")
                            ->orWhere('quantité', 'LIKE', "%{$search}%")
                              ->orWhere('status', 'LIKE', "%{$search}%")
                                    ->orWhere('id', 'LIKE', "%{$search}%")
                                        ->orWhere('utilisateur_id', 'LIKE', "%{$search}%")

                       ;
                 });
             })
             ->paginate(4);


         return view('BackOffice.PaymentDechet.index', compact('payments'));
     }

     public function show($id)
     {
              $payment = PaymentDechet::find($id);

              if (!$payment) {
                  return redirect()->route('paymentdechet.index')->with('error', 'Paiement introuvable');
              }

              return view('BackOffice.PaymentDechet.show', compact('payment'));
     }

     public function historiquePaiements()
     {
             $user = Auth::user();

             if ($user) {
                 $payments = PaymentDechet::where('user_id', $user->id)->paginate(10);

                 return view('BackOffice.PaymentDechet.historique', compact('payments'));
             }

             return redirect()->route('login')->with('error', 'Vous devez être connecté pour voir l\'historique des paiements.');
         }


         public function downloadReceipt($paymentId)
         {
             $payment = PaymentDechet::findOrFail($paymentId);

             $pdf = PDF::loadView('BackOffice.PaymentDechet.receipt', compact('payment'));
             return $pdf->download('reçu_paiement_' . $payment->id . '.pdf');
     }

}
