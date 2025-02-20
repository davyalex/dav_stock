<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Paie extends Model
{
    use HasFactory;
    protected $fillable = [
        'code',
        'employe_id',
        'montant',
        'statut', // 1 payé, 2 en attente
        'mois', // mois de paiement
        'annee', // Année de paiement
        'type_paie', // from libelle depense de la categorie charge personnel
        'date_paiement',
    ];

    public function employe()
    {
        return $this->belongsTo(Employe::class);
    }

    public function typePaie()
    {
        return $this->belongsTo(LibelleDepense::class , 'type_paie');
    }




    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->id = IdGenerator::generate(['table' => 'postes', 'length' => 10, 'prefix' =>
            mt_rand()]);
        });
    }
}
