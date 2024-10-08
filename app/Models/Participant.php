<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Participant extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'participant';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',              // Include user_id to allow mass assignment
        'collecte_dechets_id',  // Include collecte_dechets_id to allow mass assignment
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * Get the user associated with the participant.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the collecte de déchets associated with the participant.
     */
    public function collecteDechets()
    {
        return $this->belongsTo(Collectedechets::class, 'collecte_dechets_id');
    }
}
