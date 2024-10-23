<?php

namespace App\Http\Controllers\BackOfficeController;

use Stripe\Stripe;
use App\Models\User;
use Twilio\Rest\Client;
use Stripe\PaymentIntent;
use Illuminate\Http\Request;
use Stripe\Checkout\Session;
use App\Models\AnnonceDechet;
use App\Models\PaymentDechet;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Stripe\Exception\ApiErrorException;
use App\Notifications\PaymentSuccessNotification;



class AnnonceDechetsController extends Controller
{
   public function index(Request $request)
   {
       $user = Auth::user();

       if (!$user) {
           return redirect()->route('login')->with('error', 'Vous devez être connecté pour voir vos annonces.');
       }

       $search = $request->input('search');

       $annonces = AnnonceDechet::where('utilisateur_id', $user->id)
           ->when($search, function ($query, $search) {
               return $query->where(function($q) use ($search) {
                   $q->where('adresse_collecte', 'LIKE', "%{$search}%")
                     ->orWhere('type_dechet', 'LIKE', "%{$search}%")
                     ->orWhere('price', 'LIKE', "%{$search}%");
               });
           })
           ->paginate(10);

       return view('AnnonceDechet.index', compact('annonces'));
   }

    public function payed($id)
       {
           $annonce = AnnonceDechet::find($id);
           return view('AnnonceDechet.payed', compact('annonce'));
         }

    public function create()

    {
        $utilisateurs = User::all();

        return view('AnnonceDechet.create',compact('utilisateurs'));
    }


    public function store(Request $request)
    {
        // Validate the form data
        $request->validate([
            'utilisateur_id' => 'required',
            'date_demande' => 'required|date',
            'type_dechet' => 'required|string',
            'adresse_collecte' => 'required|string',
            'quantite_totale' => 'required|numeric',
            'price' => 'required|numeric',
            'image' => 'nullable|image|max:2048',
        ]);
    
        // Handle the image upload
        $imagePath = null;
        if ($request->hasFile('image')) {
            // Store the image in the 'public/annonces' directory
            $imagePath = $request->file('image')->store('something', 'public');
        }
    
        // Create the new announcement in the database
        AnnonceDechet::create([
            'utilisateur_id' => $request->input('utilisateur_id'),
            'date_demande' => $request->input('date_demande'),
            'type_dechet' => $request->input('type_dechet'),
            'status' => 'disponible',
            'adresse_collecte' => $request->input('adresse_collecte'),
            'description' => $request->input('description'),
            'quantite_totale' => $request->input('quantite_totale'),
            'price' => $request->input('price'),
            'image' => $imagePath,  // Store the image path in the database
        ]);
    
        return redirect()->route('annoncedechets.index')->with('success', 'Annonce créée avec succès.');
    }
    


   public function show($id)
   {
       $annonce = AnnonceDechet::find($id);

       if (!$annonce) {
           return redirect()->route('annoncedechets.index')->with('error', 'Annonce introuvable');
       }

       return view('AnnonceDechet.show', compact('annonce'));
   }



    public function edit(AnnonceDechet $annoncedechet)
    {
        return view('AnnonceDechet.edit', compact('annoncedechet'));
    }


    public function update(Request $request, AnnonceDechet $annoncedechet)
{
    // Validate the form data, including image if present
    $request->validate([
        'status' => 'required|string|in:disponible,indisponible',
        'description' => 'required|string|max:1000',
        'quantite_totale' => 'required|numeric|min:0.1',
        'price' => 'required|numeric|min:0',
        'date_demande' => 'required|date|before_or_equal:today',
        'adresse_collecte' => 'required|string|max:255',
        'image' => 'nullable|image|max:2048'  // Add validation for image
    ]);

    // Handle image upload if there's a new image
    if ($request->hasFile('image')) {
        // Delete the old image if it exists
        if ($annoncedechet->image) {
            Storage::disk('public')->delete($annoncedechet->image);
        }

        // Store the new image
        $imagePath = $request->file('image')->store('annonces', 'public');
        // Update the image path in the request data
        $request->merge(['image' => $imagePath]);
    }

    // Update the rest of the annonce fields
    $annoncedechet->update($request->except('image') + ['image' => $imagePath ?? $annoncedechet->image]);

    return redirect()->route('annoncedechets.index')->with('success', 'Annonce mise à jour avec succès.');
}



    public function destroy($id)
{
    $annonce = AnnonceDechet::findOrFail($id);

    $annonce->delete();

    return redirect()->route('annoncedechets.index')->with('success', 'Annonce supprimée avec succès.');
}


public function test()
{
    $id = request()->route('id');
    $annonce = AnnonceDechet::find($id);

    if (!$annonce) {
        return redirect()->back()->with('error', 'Annonce not found.');
    }

    $user = Auth::user();
    Stripe::setApiKey(config('stripe.sk'));

    $session = Session::create([
        'line_items' => [
            [
                'price_data' => [
                    'currency'     => 'eur',
                    'product_data' => [
                        'name' => $annonce->type_dechet,
                        'images' => [$annonce->image]
                            ? [asset('storage/' . $annonce->image)]
                            : ['https://via.placeholder.com/150'],
                        'description' => $annonce->description ?? 'No description',
                    ],
                    'unit_amount'  => $annonce->price * 100,
                ],
                'quantity' => 1,
            ],
        ],
        'metadata' => [
            'user_id' => $user->id,
            'annonce_dechet_id' => $annonce->id
        ],
        'mode'        => 'payment',
        'success_url' => route('AnnonceDechet.success', ['id' => $annonce->id]),
        'cancel_url'  => route('dashboard'),
    ]);

    return redirect()->away($session->url);
}

public function paymentSuccess($id)
    {
        $annonce = AnnonceDechet::find($id);
        $user = Auth::user();

        if (!$annonce) {
            return redirect()->back()->with('error', 'Annonce not found.');
        }


        PaymentDechet::create([
            'price' => $annonce->price,
            'quantité' => $annonce->quantite_totale,
            'user_id' => $user->id,
            'annonce_dechet_id' => $annonce->id,
            'payment_status' => 'paid',
            'payment_date' => now(),
        ]);

            $annonce->status = 'indisponible';
            $annonce->save();


                $annonceOwner = User::find($annonce->utilisateur_id);
                if ($annonceOwner) {
                    $annonceOwner->notify(new PaymentSuccessNotification($annonce, $user));
                }


        try {
            $sid = config('services.twilio.sid');
            $auth_token = config('services.twilio.auth_token');
            $twilio_phone_number = config('services.twilio.phone_number');
            $user_phone_number = $user->telephone;

            $twilio = new Client($sid, $auth_token);

            $message = $twilio->messages->create(
                $user_phone_number,
                [
                    'from' => $twilio_phone_number,
                    'body' => "Bonjour {$user->name}, votre paiement de {$annonce->price} TND a été effectué avec succès. Merci pour votre confiance."
                ]
            );

        } catch (\Exception $e) {
            return redirect()->route('dashboard')->with('error', 'Payment successful but failed to send SMS.');
        }

        return redirect()->route('dashboard')->with('success', 'Payment successful and recorded, SMS sent.');
    }

  public function checkout($id)
    {
     $annonce = AnnonceDechet::find($id);
     return view('AnnonceDechet.checkout', compact('annonce'));
    }


}




