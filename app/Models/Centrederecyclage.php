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

    public function dureeRestante($entrepriseId)
    {
        \Log::info('In : -------------------------------------');
        // Get the first active contract for the specified enterprise
        $contract = $this->contrats()
                         ->where('entreprise_id', $entrepriseId)
                         ->where('typeContract', 'en cours')
                         ->first();
    
        if ($contract) {
            // Calculate the expiration date
            $expirationDate = Carbon::parse($contract->date_signature)->addMonths($contract->duree_contract);
            $remainingDays = $expirationDate->diffInDays(Carbon::now(), false);
    
            // Logging information
            \Log::info('Contract ID : ' . $contract->id);
            \Log::info('Contract Start Date : ' . $contract->date_signature);
            \Log::info('Contract Duration (Months) : ' . $contract->duree_contract);
            \Log::info('Expiration Date : ' . $expirationDate);
            \Log::info('Remaining Days : ' . $remainingDays);
    
            // Return remaining days or zero if negative
            return $remainingDays > 0 ? $remainingDays : 0;
        }
    
        \Log::info('Out : -------------------------------------');
        // Return null if no active contract is found
        return null;
    }
    

}
