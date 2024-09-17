<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Magasin extends Model
{
    use HasFactory;
    public $incrementing = false;


    protected $fillable = [
        'nom',
        'created_at',
        'updated_at'
    ];


    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->id = IdGenerator::generate(['table' => 'magasins', 'length' => 10, 'prefix' =>
            mt_rand()]);
        });
    }


    public function produits()
    {
        return $this->hasMany(Produit::class);
    }


    public function achats()
    {
        return $this->hasMany(Achat::class);
    }
}
