<?php

namespace App\Http\Controllers\BackOfficeController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardControllerB extends Controller
{
    public function index()
    {
        return view('BackOffice/dashboard/dashboard'); 
    }
}
