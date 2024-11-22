<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Plat extends Model implements HasMedia
{

    use HasFactory, SoftDeletes, InteractsWithMedia , sluggable;

    public $incrementing = false;

    protected $fillable = [
        'code',
        'nom', // libellé produit
        'slug',
        'description',
        'prix',
        'categorie_menu_id',
        'statut', // oui , non
        'user_id',
    ];


    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->id = IdGenerator::generate(['table' => 'plats', 'length' => 10, 'prefix' =>
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



    public function categorieMenu()
    {
        return $this->belongsTo(CategorieMenu::class);
    }



    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // public function menu()
    // {
    //     return $this->belongsToMany(Menu::class, 'menu_produit_menu')->withTimestamps();;
    // }

//scope pour recuperer les plates active
    public function scopeActive($query)
    {
        // Retrieve only products with statut equal to 'active'
        return $query->where('statut', 'active');
    }

}
