<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlanAbonnement extends Model
{
    use HasFactory;
    protected $fillable = ['type', 'price', 'description','image'];

    // Specify the table name
    protected $table = 'plan_abonnement';

    public function abonnement()
    {
        return $this->hasMany(Abonnement::class);
    }
}
