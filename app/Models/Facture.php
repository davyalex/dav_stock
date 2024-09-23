<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Facture extends Model
{
    use HasFactory, SoftDeletes;

    public $incrementing = false;

    protected $fillable = [
        'type',
        'numero_facture',
        'date_facture',
        'montant',
        'fournisseur_id',
        'user_id',
        'created_at',
        'updated_at'
    ];


    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->id = IdGenerator::generate(['table' => 'factures', 'length' => 10, 'prefix' =>
            mt_rand()]);
        });
    }

    public function achats() 
    {
        return $this->hasMany(Achat::class);
    }


    public function fournisseur()
    {
        return $this->belongsTo(Fournisseur::class, 'fournisseur_id');
    }
   public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
