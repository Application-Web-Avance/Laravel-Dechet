<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Typedechets extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'typedechets'; // You can keep this if the table is named 'typedechets'

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'type',    // assuming this is a column name in the table
        'description',
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;

    // Relation One-to-Many avec CollecteDechet
    public function collecteDechets()
    {
        return $this->hasMany(Collectedechets::class); // Make sure the model name is correct here
    }
    public function centresDeRecyclage()
    {
        return $this->hasMany(Centrederecyclage::class, 'type_dechet_id');
    }
}
