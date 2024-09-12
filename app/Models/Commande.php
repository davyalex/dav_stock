<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Commande extends Model
{
    use HasFactory;


    
    public $incrementing = false;

    protected $fillable = [
        'code',
        'nombre_produit', 
        'statut',
        'mode_livraison',
        'adresse_livraison',
        'montant_total',
        'date_commande', 
        'user_id',
    ];


    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->id = IdGenerator::generate(['table' => 'commandes', 'length' => 10, 'prefix' =>mt_rand()]);
            // $model->code = 'CMD-' . str_pad(Commande::max('id') + 1, 8, '0', STR_PAD_LEFT);
            // $model->code = IdGenerator::generate(['table' => 'commandes', 'length' => 10, 'prefix' =>mt_rand()]);

          
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }



    // public function products():BelongsToMany {
    //     return $this->belongsToMany(Product::class)->withPivot(['quantity','unit_price','total', 'options','available'])->withTimestamps();
    // }

}
