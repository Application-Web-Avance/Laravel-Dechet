<?php

namespace App\Http\Controllers\BackOfficeController;

use App\Http\Controllers\Controller;
use App\Models\Centrederecyclage;
use App\Models\Typedechets;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TypeDechetsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Auth::user()->role == 'Responsable_Centre' || Auth::user()->role == 'Responsable_Entreprise') {
            return view('BackOffice.GestionCentre.type-dechet');
        } else {
            return redirect()->route('AccessDenied');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
        ]);

        $typeDechet = new Typedechets();
        $typeDechet->type = $request->input('type');
        $typeDechet->description = $request->input('description', null);  // Optional field, can be null

        $typeDechet->save();

        return redirect()->route('centres.create')->with('success', 'Type de déchet créé avec succès!');
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
        //
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
            return view('BackOffice/GestionCentre/type-dechet');
        }else {
            return redirect()->route('AccessDenied');
        }
    }
}
