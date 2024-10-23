<?php

namespace App\Http\Controllers\FrontOfficeController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AnnonceDechet;

class DashboardControllerF extends Controller
{
    public function index()
    {
        return view('FrontOffice/home/home');
        $annonces = AnnonceDechet::all();
        return view('FrontOffice/home/home', compact('annonces'));
    }
}
