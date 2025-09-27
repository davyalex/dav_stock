<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Categorie extends Model
{
    use HasFactory, sluggable, SoftDeletes;

    public $incrementing = false;

    protected $fillable = [
        'name', // unique
        'slug',
        'status',
        'url',
        'position',
        'parent_id',
    ];

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->id = IdGenerator::generate(['table' => 'categories', 'length' => 10, 'prefix' =>
            mt_rand()]);
        });
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    public function children()
    {
        return $this->hasMany(Categorie::class, 'parent_id');
    }

    public function parent()
    {
        return $this->belongsTo(Categorie::class, 'parent_id');
    }


    public function produits()
    {
        return $this->hasMany(Produit::class )->where('statut' , 'active');
    }

    public function ancestors()
    {
        return $this->parent()->with('ancestors');
    }

    public function descendants()
    {
        return $this->children()->with('descendants');
    }


    public function getPrincipalCategory() // recuperer la categorie principale 
    {
        if ($this->parent) {
            return $this->parent->getPrincipalCategory();
        }

        return $this;
    }





    //scopes active
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
    


   
}
