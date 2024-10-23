<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Abonnement extends Model
{
    use HasFactory;

    protected $fillable = [
        'date_debut',
        'plan_abonnement_id',
        'image',
        'user_id',
        'is_accepted',
        'is_payed'
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'abonnement';


    public function user()
    {
        return $this->belongsTo(User::class);
    }
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;
}
