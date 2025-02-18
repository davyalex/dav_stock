<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Paie extends Model
{
    use HasFactory;
    protected $fillable = [
        'employe_id',
        'montant',
        'type', // 1 salaire, 2 prime, 3 indemnité, 4 avance
        'statut', // 1 payé, 2 en attente
        'date_paiement',
    ];

    public function employe()
    {
        return $this->belongsTo(Employe::class);
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
