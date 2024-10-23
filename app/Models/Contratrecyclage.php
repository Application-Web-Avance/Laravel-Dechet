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
        'entreprise_id',
        'centre_id',
        'pdf_proof', // Add this field
    ];
    protected $appends = ['duree_restante'];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;

    public function entreprise(): BelongsTo
    {
        return $this->belongsTo(Entrepriserecyclage::class, 'entreprise_id');
    }


    public function centre(): BelongsTo
    {
        return $this->belongsTo(Centrederecyclage::class);
    }

    

    public function getDateFinAttribute()
    {
        $startDate = \Carbon\Carbon::parse($this->date_signature);
        return $startDate->addMonths($this->duree_contract)->format('d-m-Y');
    }


}
