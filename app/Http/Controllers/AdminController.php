<?php

namespace App\Http\Controllers;

use App\Models\Demanderole;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class AdminController extends Controller
{
    // Method to get all users with the role 'verifier'
    public function getUsersVerified()
    {
        // Check if the authenticated user is an admin
        if (Auth::check() && Auth::user()->role !== 'admin') {
            // Redirect to access denied route if the user is not an admin
            return redirect()->route('AccessDenied');
        }

        // Get all users with the role 'verifier', paginated (for example, 10 per page)
        $users = User::with('demandeRole')
            ->where('role', 'verifier')
            ->paginate(10); // Pagination applied here

        // Return the view with the users' data
        return view('backOffice.AdminView.index', ['users' => $users]);
    }

    // Method to accept a user
    public function accept($id)
    {
        // Find the user by ID
        $user = User::find($id);

        // Check if the user exists
        if (!$user) {
            return redirect()->back()->with('error', 'Utilisateur introuvable.');
        }

        // Get the role requested from the demandeRole table
        $demandeRole = Demanderole::where('user_id', $id)->first(); // Adjust field name if needed

        if (!$demandeRole) {
            return redirect()->back()->with('error', 'Aucune demande de rôle trouvée pour cet utilisateur.');
        }

        // Set the user's role to the requested role
        $user->role = $demandeRole->role_requested; // Assuming 'role_requested' is the column name
        $user->save(); // Save changes to the user

        // Update the demandeRole entry to mark it as accepted
        $demandeRole->typedemande = 'accepted'; // Change the type of request to accepted
        $demandeRole->save(); // Save changes to the demandeRole

        // Send an email to the user notifying them of their acceptance
        Mail::to($user->email)->send(new \App\Mail\UserAccepted($user, $demandeRole->role_requested)); // Create this Mailable

        // Redirect back with a success message
        return redirect()->route('usersA.index')->with('success', 'Utilisateur accepté avec succès.');
    }


    // Method to reject a user
    public function reject($id)
    {
        // Find the user by ID
        $user = User::find($id);

        // Check if the user exists
        if (!$user) {
            return redirect()->back()->with('error', 'Utilisateur introuvable.');
        }

        // Send an email to the user notifying them that their request has been rejected
        Mail::to($user->email)->send(new \App\Mail\UserRejected($user)); // Create this Mailable

        // Delete the user from the database
        $user->delete();

        // Redirect back with a success message
        return redirect()->route('usersA.index')->with('success', 'Utilisateur rejeté avec succès.');
    }
}
