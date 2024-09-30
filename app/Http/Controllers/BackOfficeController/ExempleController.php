<?php

namespace App\Http\Controllers\BackOfficeController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExempleController extends Controller
{
    public function index()
    {
        // Test if a user is authenticated
        if (Auth::check()) {
            // The user is authenticated
            $user = Auth::user(); // Get the currently authenticated user

                    // Get the user ID
        $id_user = $user->id;
            // Display user info in a debug message
            dd("User is authenticated:", $id_user); // Directly output the user object
        } else {
            // The user is not authenticated
            dd("User is not authenticated");
        }

        // Static data for the view
        $personnes = [
            ['nom' => 'Dupont', 'prenom' => 'Jean', 'age' => 30],
            ['nom' => 'Martin', 'prenom' => 'Sophie', 'age' => 25],
            ['nom' => 'Durand', 'prenom' => 'Luc', 'age' => 40],
            ['nom' => 'Bernard', 'prenom' => 'Marie', 'age' => 22],
            ['nom' => 'Rousseau', 'prenom' => 'Pierre', 'age' => 35]
        ];
        $name = "youssef";

        return view('BackOffice/GestionExemple/index', compact('personnes', 'name'));
    }
}
