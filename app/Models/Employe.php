<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Employe extends Model
{
    use HasFactory;
    protected $fillable = [
        'code',
        'nom',
        'prenom',
        'email',
        'telephone',
        'adresse',
        'date_embauche',
        'salaire_base',
        'poste_id',
        'statut',

    ];


    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->id = IdGenerator::generate(['table' => 'postes', 'length' => 10, 'prefix' =>
            mt_rand()]);
        });
    }


    public function poste()
    {
        return $this->belongsTo(Poste::class);
    }

    //relation entre employe et paie
    public function paies()
    {
        return $this->hasMany(Paie::class);
    }
}
