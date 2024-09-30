<?php

namespace App\Http\Controllers\FrontOfficeController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return view('FrontOffice/home/home'); 
    }
}
