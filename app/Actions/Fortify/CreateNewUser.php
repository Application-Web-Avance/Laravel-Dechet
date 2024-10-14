<?php

namespace App\Actions\Fortify;

use App\Models\User;
use App\Models\Demanderole; // Assurez-vous d'importer le modèle Demanderole
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'adresse' => ['nullable', 'string', 'max:255'],
            'telephone' => ['nullable', 'string', 'max:20'],
            'cin' => ['nullable', 'string', 'max:20'],
            'date_naissance' => ['nullable', 'date'],
            'nomPrincipale' =>  ['nullable', 'string', 'max:255'],
            'role' => ['required', 'in:Responsable_Centre,Responsable_Entreprise,user'], // Validation pour le rôle
            'proof_pdf' => ['nullable', 'file', 'mimes:pdf'], // Validation pour le PDF
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        ])->validate();

        // Créer l'utilisateur
        $role = $input['role'];

        // Change the role to "verifier" if it is Responsable_Centre or Responsable_Entreprise
        if (in_array($role, ['Responsable_Centre', 'Responsable_Entreprise'])) {
            $role = 'verifier';
        } elseif ($role !== 'verifier') { // Set role to "user" if it's not "verifier"
            $role = 'user';
        }

        // Créer l'utilisateur
        $user = User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
            'adresse' => $input['adresse'],
            'nomPrincipale' => $input['nomPrincipale'],
            'telephone' => $input['telephone'],
            'cin' => $input['cin'],
            'date_naissance' => $input['date_naissance'],
            'role' => $role, // Assignation du rôle
        ]);

        // Enregistrer dans la table Demanderole si le rôle est Responsable_Centre ou Responsable_Entreprise
        if (in_array($input['role'], ['Responsable_Centre', 'Responsable_Entreprise'])) {
            $pdfPath = null;

            // Vérifiez si un PDF a été téléchargé et déplacez-le dans le bon dossier
            if (request()->hasFile('proof_pdf')) {
                $pdfPath = request()->file('proof_pdf')->store('proofs', 'public');
            }

            Demanderole::create([
                'role_requested' => $input['role'],
                'proof_pdf' => $pdfPath,
                'nom_centre' => $input['nomPrincipale'], // Utiliser le champ nomPrincipale comme nom_centre
                'user_id' => $user->id, // Lier le demandeur à l'utilisateur créé
                'typedemande' => 'en cours'
            ]);
        }

        return $user;
    }
}
