<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;


class Variante extends Model
{

    use HasFactory,  SoftDeletes, Sluggable;

    public $incrementing = false;

    protected $fillable = [
        'libelle',
        'created_at',
        'updated_at'
    ];

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->id = IdGenerator::generate(['table' => 'variantes', 'length' => 10, 'prefix' =>
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


    public function produits(): BelongsToMany
    {
        return $this->belongsToMany(Produit::class ,'produit_variante')->withPivot(['quantite', 'prix', 'total'])->withTimestamps();
    }
}
