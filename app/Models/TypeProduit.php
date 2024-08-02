<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class TypeProduit extends Model
{
    use HasFactory, sluggable, SoftDeletes;

    public $incrementing = false;

    protected $fillable = [
        'libelle',
        'slug',
        'status',
        'url',
        'position',
    ];


    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->id = IdGenerator::generate(['table' => 'type_produits', 'length' => 10, 'prefix' =>
            mt_rand()]);
        });
    }


    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'libelle'
            ]
        ];
    }



    public function produits()
    {
        return $this->hasMany(Produit::class);
    }

    public function categories()
    {
        return $this->hasMany(Categorie::class);
    }

    
}
