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
        'numero_facture',
        'date_achat',
        'statut',
        'type_produit_id',
        'produit_id',
        'fournisseur_id',
        'format_id',
        'quantite_format',      //quantité de format
        'quantite_in_format',   //quantité dans un format
        'quantite_stocke',      //quantite total des piece dans les formats
        'prix_unitaire_format', //prix unitaire d'un format
        'prix_total_format',    //prix total d'un format
        'prix_achat_unitaire', //prix d'achat unitaire d'une piece dans un format (calcule automatique)
        'prix_vente_unitaire', //prix de vente par unite
        'unite_id',             // unite de sortie(vente)
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
