<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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
        'client_id',
        'user_id',
        'caisse_id',



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

    public function client() // client
    {
        return $this->belongsTo(User::class , 'client_id');
    }


    public function user() // caissier
    {
        return $this->belongsTo(User::class , 'user_id');
    }


    public function caisse() // caisse qui confirme la vente
    {
        return $this->belongsTo(Caisse::class);
    }




    public function produits():BelongsToMany {
        return $this->belongsToMany(Produit::class)->withPivot(['quantite','prix_unitaire','total'])->withTimestamps();
    }

}
