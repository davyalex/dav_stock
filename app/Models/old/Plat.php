<?php

namespace App\Models;

use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Spatie\MediaLibrary\InteractsWithMedia;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Plat extends Model implements HasMedia
{

    use HasFactory, SoftDeletes, InteractsWithMedia, sluggable;

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



    public function categorieMenu()  // categorie pour les menus 
    {
        return $this->belongsTo(CategorieMenu::class);
    }



    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function menu()
    {
        return $this->belongsToMany(Menu::class, 'menu_plat')
            ->withPivot('categorie_menu_id')
            ->withTimestamps();
    }

    //MENU

    // Relation pour les compléments d'un plat
    public function complements()
    {
        return $this->belongsToMany(Plat::class, 'plat_complement', 'plat_id', 'complement_id')
            ->withPivot('menu_id')
            ->withTimestamps();
    }

    // Relation pour les garnitures d'un plat
    public function garnitures()
    {
        return $this->belongsToMany(Plat::class, 'plat_garniture', 'plat_id', 'garniture_id')
            ->withPivot('menu_id')
            ->withTimestamps();
    }


    public function commandes(): BelongsToMany
    {
        return $this->belongsToMany(Commande::class)->withPivot(['quantite', 'prix_unitaire', 'total', 'garniture', 'complement'])->withTimestamps();
    }


    public function ventes()
    {
        return $this->belongsToMany(Vente::class, 'plat_vente')
            ->withPivot('quantite', 'prix_unitaire', 'total', 'complement', 'garniture')
            ->withTimestamps();
    }

    //scope pour recuperer les plates active
    public function scopeActive($query)
    {
        // Retrieve only products with statut equal to 'active'
        return $query->where('statut', 'active');
    }
}
