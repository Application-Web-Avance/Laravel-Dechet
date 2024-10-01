<?php

namespace App\Models;

use App\Models\Centrederecyclage;
use App\Models\Entrepriserecyclage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Contratrecyclage extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'contratrecyclage';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'date_signature',
        'duree_contract',
        'montant',
        'typeContract',
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;

    public function entrprise(): BelongsTo
    {
        return $this->belongsTo(Entrepriserecyclage:: class);
    }

    public function centre(): BelongsTo
    {
        return $this->belongsTo(Centrederecyclage:: class);
    }
}
