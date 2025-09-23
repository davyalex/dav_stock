<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CategorieMenu extends Model
{
    use HasFactory, sluggable, SoftDeletes;

    public $incrementing = false;

    protected $fillable = [
        'nom', // unique
        'slug',
        'statut',
        'position'
    ];

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->id = IdGenerator::generate(['table' => 'categorie_menus', 'length' => 10, 'prefix' =>
            mt_rand()]);
        });
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'nom'
            ]
        ];
    }

    public function plats() // plat du menu
    {
        return $this->hasMany(Plat::class);
    }


    public function scopeActive($query)
    {
        // Retrieve only categories with statut equal to 'active'
        return $query->where('statut', 'active');
    }
}
