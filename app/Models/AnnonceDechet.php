<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class AnnonceDechet extends Model
{
   use HasFactory;


   /**
    * The table associated with the model.
    *
    * @var string
    */
   protected $table = 'annonce_dechets';


   /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
   protected $fillable = [
       'utilisateur_id',
       'type_dechet',
       'date_demande',
       'status',
       'adresse_collecte',
       'description',
       'quantite_totale',
       'price',
       'image',
   ];


   /**
    * Indicates if the model should be timestamped.
    *
    * @var bool
    */
   public $timestamps = true;


   /**
    * Get the user that made the collection request.
    */
   public function utilisateur()
   {
       return $this->belongsTo(User::class, 'utilisateur_id');
   }
}
