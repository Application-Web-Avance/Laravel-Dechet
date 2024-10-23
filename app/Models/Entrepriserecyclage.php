<?php

namespace App\Models;

use App\Models\User;
use App\Models\Contratrecyclage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Entrepriserecyclage extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'entrepriserecyclage';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nom',
        'adresse',
        'numero_siret',
        'specialite',
        'image_url',
        'description',
        'user_id'
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;

    public function contrats(): HasMany
    {
        return $this->hasMany(Contratrecyclage::class, 'entreprise_id'); // Corrected
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
