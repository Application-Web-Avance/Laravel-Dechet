<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Centrederecyclage extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'centrederecyclage';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nom',
        'adresse',
        'horaires',
        'id_utilisateur',
        'type_dechet_id'
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;

    public function user()
    {
        return $this->belongsTo(User::class, 'id_utilisateur');
    }
    public function typeDechet()
    {
        return $this->belongsTo(Typedechets::class, 'type_dechet_id');
    }
}
