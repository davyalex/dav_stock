<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ajustement extends Model
{
       use HasFactory;

    public $incrementing = false;

    protected $fillable = [
        'code',
        'date_entree',
        'user_id',
    ];

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->id = IdGenerator::generate(['table' => 'ajustements', 'length' => 10, 'prefix' =>
            mt_rand()]);
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function produits()
    {
        return $this->belongsToMany(Produit::class, 'ajustement_produit', 'ajustement_id', 'produit_id')
            ->withPivot('stock_disponible', 'stock_ajuste', 'type_ajustement')
            ->withTimestamps();
    }
}
