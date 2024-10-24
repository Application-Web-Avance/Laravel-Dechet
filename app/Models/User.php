<?php

namespace App\Models;

use App\Models\Entrepriserecyclage;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Jetstream\HasProfilePhoto;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, HasProfilePhoto, Notifiable, TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'adresse', // Assurez-vous que l'adresse est inclus
        'telephone', // Assurez-vous que le téléphone est inclus
        'cin', // Assurez-vous que le CIN est inclus
        'date_naissance', // Assurez-vous que la date de naissance est incluse
        'role', // Ajoutez le champ role
        'is_blocked',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];

    /**
     * Get the demande role associated with the user.
     */
    public function demandeRole()
    {
        return $this->hasOne(Demanderole::class);
    }
    public function entreprise(): HasMany
    {
        return $this->hasMany(Entrepriserecyclage::class,'user_id') ;
    }


    // Relation One-to-Many avec CollecteDechet (Responsable des collectes)
    public function collecteDechets()
    {
        return $this->hasMany(Collectedechets::class);
    }

    // Relation Many-to-Many avec CollecteDechet via la table de pivot (Participant aux collectes)
    public function participations()
    {
        return $this->belongsToMany(Collectedechets::class, 'participant')
                    ->withTimestamps();
    }


    //ce code est le responsable de redirection l'ors je clicker sur boutton connecter dans login
    public function getRedirectRoute(): string
    {
        return match ($this->role) {
            'Responsable_Centre', 'Responsable_Entreprise','admin' => '/back/dashboard',
            'user' => '/front/home',
            default => '/login',
        };
    }
    public function centresDeRecyclage()
    {
        return $this->hasMany(CentreDeRecyclage::class);
    }

}
