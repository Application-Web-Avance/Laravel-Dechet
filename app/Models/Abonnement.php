<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Abonnement extends Model
{
    use HasFactory;
    protected $fillable = ['date_debut', 'plan_abonnement_id', 'image'];

    // Specify the table name
    protected $table = 'abonnement';

    public function planAbonnement()
    {
        return $this->belongsTo(PlanAbonnement::class);
    }
}
