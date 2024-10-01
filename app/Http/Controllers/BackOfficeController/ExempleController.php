<?php

namespace App\Http\Controllers\BackOfficeController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ExempleController extends Controller
{
    public function index()
    {

        // Tableau statique de données
        $personnes = [
            ['nom' => 'Dupont', 'prenom' => 'Jean', 'age' => 30],
            ['nom' => 'Martin', 'prenom' => 'Sophie', 'age' => 25],
            ['nom' => 'Durand', 'prenom' => 'Luc', 'age' => 40],
            ['nom' => 'Bernard', 'prenom' => 'Marie', 'age' => 22],
            ['nom' => 'Rousseau', 'prenom' => 'Pierre', 'age' => 35]
        ];
        $name="youssef";
        return view('BackOffice/GestionExemple/index', compact('personnes','name')); 
    }
}
