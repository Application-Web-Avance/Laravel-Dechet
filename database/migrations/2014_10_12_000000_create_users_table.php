<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Champ pour le nom
            $table->string('email')->unique(); // Champ pour l'email
            $table->timestamp('email_verified_at')->nullable(); // Champ pour la vérification de l'email
            $table->string('password'); // Champ pour le mot de passe
            $table->rememberToken(); // Champ pour se souvenir de l'utilisateur
            $table->foreignId('current_team_id')->nullable(); // ID de l'équipe courante
            $table->string('profile_photo_path', 2048)->nullable(); // Champ pour la photo de profil
            // Ajoutez vos nouveaux champs ici
            $table->string('adresse')->nullable(); // Champ pour l'adresse
            $table->string('telephone')->nullable(); // Champ pour le téléphone
            $table->string('cin')->nullable(); // Champ pour le CIN
            $table->date('date_naissance')->nullable(); // Champ pour la date de naissance
            $table->enum('role', ['Responsable_Centre', 'Responsable_Entreprise', 'admin', 'user','verifier'])->default('user'); // Champ pour le rôle
            $table->string('nomPrincipale')->nullable(); 
            $table->timestamps(); // Champs de timestamps
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
