<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sortie extends Model
{
    use HasFactory , SoftDeletes;
    
    public $incrementing = false;

    protected $fillable = [
        'code',
        'date_sortie',
        'user_id',
    ];

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->id = IdGenerator::generate(['table' => 'sorties', 'length' => 10, 'prefix' =>
            mt_rand()]);
        });
    }

    public function produits() {
        return $this->belongsToMany(Produit::class , 'produit_sortie' , 'sortie_id' , 'produit_id')->withPivot(['stock_disponible','stock_sortie'])->withTimestamps();
    }

   
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    
}
