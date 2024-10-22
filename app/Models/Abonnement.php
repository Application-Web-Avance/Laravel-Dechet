<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Abonnement extends Model
{
    use HasFactory;
    protected $fillable = ['date_debut', 'plan_abonnement_id', 'image','user_id'];

    protected $table = 'abonnement';

    public function planAbonnement()
    {
        return $this->belongsTo(PlanAbonnement::class);
    }

    /**
     * Get the user that owns the abonnement.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
