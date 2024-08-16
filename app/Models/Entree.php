<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Entree extends Model
{
    use HasFactory, SoftDeletes;

    public $incrementing = false;

    protected $fillable = [
        'code',
        'statut',
        'type_entree_id', // bar ? restaurant
        'produit_id',
        'fournisseur_id',
        'format_id',
        'quantite_format',
        'unite_id',
        // 'quantite_unite_unitaire',
        // 'quantite_unite_total',
        // 'indice_mesure', // poids ? unite
        'quantite_stockable',
        'prix_achat_unitaire',
        'prix_achat_total',
        'prix_vente_unitaire', // -->bar
        'prix_vente_total',  // -->bar
        'user_id'
    ];

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->id = IdGenerator::generate(['table' => 'entrees', 'length' => 10, 'prefix' =>
            mt_rand()]);
        });
    }



    public function type_entree() // BAR ? RESTAURANT
    {
        return $this->belongsTo(Categorie::class, 'type_entree_id');
    }
    public function produit() // BAR ? RESTAURANT
    {
        return $this->belongsTo(Produit::class, 'produit_id');
    }
    public function fournisseur() // BAR ? RESTAURANT
    {
        return $this->belongsTo(Fournisseur::class, 'fournisseur_id');
    }
    public function format() // BAR ? RESTAURANT
    {
        return $this->belongsTo(Format::class, 'format_id');
    }

    public function unite() // BAR ? RESTAURANT
    {
        return $this->belongsTo(Unite::class, 'unite_id');
    }

    public function user() // BAR ? RESTAURANT
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
