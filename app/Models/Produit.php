<?php

namespace App\Models;

use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Spatie\MediaLibrary\InteractsWithMedia;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Produit extends Model implements HasMedia
{
    use HasFactory, SoftDeletes, InteractsWithMedia, sluggable;

    public function registerMediaConversions(Media $media = null): void
    {

        // $this->addMediaConversion('large-size')
        // ->width(570) // par exemple 300px de large
        // ->height(470) // 300px de hauteur
        // ->sharpen(10); // pour améliorer la qualité si besoin

        $this->addMediaConversion('standard-size')
            ->width(300) // par exemple 300px de large
            ->height(300) // 300px de hauteur
            ->sharpen(10); // pour améliorer la qualité si besoin


        $this->addMediaConversion('small-size')
            ->width(150) // par exemple 300px de large
            ->height(150) // 300px de hauteur
            ->sharpen(10); // pour améliorer la qualité si besoin
    }

    public $incrementing = false;

    protected $fillable = [
        'code',
        'nom', // libellé produit
        'slug',
        'description',
        'prix',
        'stock_initial',
        'stock', //quantité
        'stock_alerte', // stock de securite
        'categorie_id',
        'type_id', // type produit
        'statut', // oui , non
        'user_id',
        'magasin_id',
        'quantite_unite', // qté unite de mesure
        'unite_id',
    ];


    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->id = IdGenerator::generate(['table' => 'produits', 'length' => 10, 'prefix' =>
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



    public function categorie()
    {
        return $this->belongsTo(Categorie::class, 'categorie_id');
    }


    public function typeProduit()
    {
        return $this->belongsTo(Categorie::class, 'type_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function unite() 
    {
        return $this->belongsTo(Unite::class, 'unite_id');
    }

    public function magasin()
    {
        return $this->belongsTo(Magasin::class);
    }

    public function achats() // 
    {
        return $this->hasMany(Achat::class);
    }


    public function menus()
    {
        return $this->belongsToMany(Menu::class, 'menu_produit')->withTimestamps();
    }

    public function commandes(): BelongsToMany
    {
        return $this->belongsToMany(Commande::class)->withPivot(['quantite', 'prix_unitaire', 'total'])->withTimestamps();
    }

    public function sorties() { // sortie de stock
        return $this->belongsToMany(Sortie::class)->withPivot(['quantite_existant','quantite_utilise','unite_id', 'unite_sortie'])->withTimestamps();
    }

    public function inventaires() {
        return $this->belongsToMany(Produit::class)->withPivot(['stock_initial','stock_theorique','stock_physique','ecart' ,'etat' , 'observation'])->withTimestamps();
    }

    public function ventes()
    {
        return $this->belongsToMany(Vente::class, 'produit_vente')
            ->withPivot('quantite', 'prix_unitaire', 'total')
            ->withTimestamps();
    }
}
