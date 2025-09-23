<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ModePaiement extends Model
{
    use HasFactory;

    public $incrementing = false;


    protected $fillable = [
        'code',
        'libelle',
        'description',
        'statut',
        'created_at',
        'updated_at'
    ];


    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->id = IdGenerator::generate(['table' => 'mode_paiements', 'length' => 10, 'prefix' =>
            mt_rand()]);
        });
    }



   public function scopeActive($query)
    {
       return $query->where('statut', 'active');
   }


   
}
