<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Achat extends Model
{
    use HasFactory, SoftDeletes;

    public $incrementing = false;

    protected $fillable = [
        'code',
        'statut',
        'type_produit_id', // boissons ? ingredients
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
        'user_id',
        'magasin_id',

    ];

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->id = IdGenerator::generate(['table' => 'achats', 'length' => 10, 'prefix' =>
            mt_rand()]);
        });
    }

    public function magasin()
    {
        return $this->belongsTo(Magasin::class, 'magasin_id');
    }

    public function type_produit() 
    {
        return $this->belongsTo(Categorie::class, 'type_produit_id');
    }
    public function produit() 
    {
        return $this->belongsTo(Produit::class, 'produit_id');
    }
    public function fournisseur() 
    {
        return $this->belongsTo(Fournisseur::class, 'fournisseur_id');
    }
    public function format() 
    {
        return $this->belongsTo(Format::class, 'format_id');
    }

    public function unite() 
    {
        return $this->belongsTo(Unite::class, 'unite_id');
    }

    public function user() 
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function ajustements() 
    {
        return $this->hasMany(Ajustement::class);
    }
}
