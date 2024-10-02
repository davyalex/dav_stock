<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Vente extends Model
{
    use HasFactory;
    protected $fillable = [
        'code',
        'date_vente',
        'montant_total',
        // 'remise',
        // 'montant_paye',
        // 'montant_restant',
        // 'statut_paiement',
        // 'mode_paiement',
        'user_id',
        'client_id',
        'caisse_id',
    ];

    public $incrementing = false;

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->id = IdGenerator::generate(['table' => 'ventes', 'length' => 10, 'prefix' =>
            mt_rand()]);
        });
    }


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function caisse()
    {
        return $this->belongsTo(Caisse::class, 'caisse_id');
    }
    public function produits()
    {
        return $this->belongsToMany(Produit::class, 'produit_vente')
            ->withPivot('quantite', 'prix_unitaire', 'total')
            ->withTimestamps();
    }
}
