<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use App\Models\Entrepriserecyclage;
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
        return $this->hasMany(Entrepriserecyclage:: class,'user_id') ;
    }
}
