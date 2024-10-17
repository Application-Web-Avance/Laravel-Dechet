<?php

namespace App\Http\Controllers\BackOfficeController;

use App\Http\Controllers\Controller;
use App\Models\Centrederecyclage;
use App\Models\Collectedechets;
use App\Models\Typedechets;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CentreDeRecyclageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->role == 'Responsable_Centre' || Auth::user()->role == 'Responsable_Entreprise') {
            $isAdmin = false;
            $centres = CentreDeRecyclage::where('id_utilisateur', auth()->id())->get();
            return view('BackOffice/GestionCentre/index',compact('centres','isAdmin'));
        }
        if(Auth::user()->role == 'admin'){
            $centres = CentreDeRecyclage::all();
            $isAdmin = true;
            return view('BackOffice/GestionCentre/index',compact('centres','isAdmin'));
        }else {
            return redirect()->route('AccessDenied');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $typesDechets = Typedechets::all();
        return view('BackOffice/GestionCentre.create', compact( 'typesDechets'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'nom' => 'required|string|max:255',
            'adresse' => 'required|string',
            'horaires' => 'required|string',
            'types_dechets' => 'array', // Types of déchets
            'types_dechets.*' => 'exists:type_dechets,id', // Ensure each type exists
        ]);

        // Add the authenticated user's ID to the data
        $data['id_utilisateur'] = auth()->id();

        // Create the recycling center
        $centre = CentreDeRecyclage::create($data);
//        $centre->typeDeDechets()->sync($request->types_dechets); // Sync the types of waste

        return redirect()->route('centres.index')->with('success', 'Centre created successfully');
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Check if the user has the required role
        if (Auth::user()->role == 'Responsable_Centre' || Auth::user()->role == 'Responsable_Entreprise') {

            $centre = Centrederecyclage::where('id', $id);

            $centre->delete();
            // $flasher->addSuccess('Collect Dechet ajouté avec succès!');

            return redirect()->route('centres.index')->with('success', 'Le centres a été supprimée avec succès');
        } else {
            return redirect()->route('AccessDenied');
        }
    }
    public function getUsersVerified()
    {
        // Check if the authenticated user is an admin
        if (Auth::check() && Auth::user()->role !== 'Responsable_Centre' && Auth::user()->role !== 'admin') {
            // Redirect to access denied route if the user is not an admin
            return redirect()->route('AccessDenied');
        }

        // Get all users with the role 'verifier', paginated (for example, 10 per page)
        $users = User::with('demandeRole')
            ->where('role', 'verifier')
            ->paginate(10); // Pagination applied here

        if (Auth::user()->role == 'Responsable_Centre' || Auth::user()->role == 'Responsable_Entreprise') {
            $isAdmin = false;
            $centres = CentreDeRecyclage::where('id_utilisateur', auth()->id())->get();
            return view('BackOffice/GestionCentre/index',compact('centres','isAdmin'));
        }
        if(Auth::user()->role == 'admin'){
            $centres = CentreDeRecyclage::all();
            $isAdmin = true;
            return view('BackOffice/GestionCentre/index',compact('centres','isAdmin'));
        }else {
            return redirect()->route('AccessDenied');
        }
    }
}
