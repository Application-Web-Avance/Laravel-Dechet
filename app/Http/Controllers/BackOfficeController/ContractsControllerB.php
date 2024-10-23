<?php

namespace App\Http\Controllers\BackOfficeController;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Contratrecyclage;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ContractsControllerB extends Controller
{
    public function index(){
        // Get the authenticated user
        $user = Auth::user();

        // Retrieve contracts for this user
        $contracts = Contratrecyclage::with('entreprise', 'centre')
            ->paginate(2); // Assuming you want pagination

        return view('BackOffice.gestionContract.index', compact('contracts'));
    }

    public function updateStatus(Request $request, $id){
        $contract = Contratrecyclage::find($id);
        
        if (!$contract) {
            return response()->json(['success' => false, 'message' => 'Contract not found'], 404);
        }

        $contract->typeContract = $request->input('typeContract');
        $contract->save();

        return response()->json(['success' => true]);
    }


    
 
    

    

}
