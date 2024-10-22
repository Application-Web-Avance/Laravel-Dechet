<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Collectedechets extends Model
{
    use HasFactory;

    // Définir les champs autorisés
    protected $fillable = ['date', 'lieu', 'nbparticipant','Maxnbparticipant','description', 'type_de_dechet_id', 'user_id', 'image','nomEvent'];

    // Relation Many-to-One avec TypeDeDechet
    public function typeDeDechet()
    {
        return $this->belongsTo(Typedechets::class);
    }

    // Relation Many-to-One avec User (Responsable)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relation Many-to-Many avec Participant via table pivot
    public function participants()
    {
        return $this->belongsToMany(User::class, 'participant', 'collecte_dechets_id', 'user_id')
                    ->withTimestamps();
    }


    protected $appends = ['distance'];

    public function getDistanceAttribute() {
        return $this->attributes['distance'] ?? null;
    }
}


