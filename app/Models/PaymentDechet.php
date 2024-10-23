<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class PaymentDechet extends Model
{
   use HasFactory;


   /**
    * The table associated with the model.
    *
    * @var string
    */
   protected $table = 'payment_dechets';


   /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
   protected $fillable = [
       'price',
       'quantité',
       'payment_status',
       'payment_date',
       'annonce_dechet_id',
       'user_id',
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
       return $this->belongsTo(User::class, 'user_id');
   }


   /**
    * Get the recycling announcement associated with the payment.
    */
   public function annonceDechet()
   {
       return $this->belongsTo(AnnonceDechet::class, 'annonce_dechet_id');
   }
}
