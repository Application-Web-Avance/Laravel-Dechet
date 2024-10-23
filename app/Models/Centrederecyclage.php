<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\Contratrecyclage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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


    public function contrats(): HasMany
    {
        return $this->hasMany(Contratrecyclage:: class,'centre_id') ;
    }


    public function user()
    {
        return $this->belongsTo(User::class, 'id_utilisateur');
    }
    public function typeDechet()
    {
        return $this->belongsTo(Typedechets::class, 'type_dechet_id');
    }
}
