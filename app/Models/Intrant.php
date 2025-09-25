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

class Intrant extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia, sluggable;



    public $incrementing = false;

    protected $fillable = [
        'code',
        'nom', // libellé produit
        'slug',
        'description',
        'prix', // prix de vente
        // 'stock_initial', // stock des nouveau achat apres inventaire
        'stock', //quantité
        // 'stock_dernier_inventaire', // stock du dernier inventaire
        'stock_alerte', // stock de securite
        'statut', // active , desactive
        'user_id',
        // 'magasin_id',
      
    ];


    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->id = IdGenerator::generate(['table' => 'intrants', 'length' => 10, 'prefix' =>
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



  



    public function user()
    {
        return $this->belongsTo(User::class);
    }

   

  

    public function sorties()
    { // sortie de stock
        return $this->belongsToMany(Sortie::class , 'produit_sortie', 'produit_id', 'sortie_id')->withPivot(['stock_disponible', 'stock_sortie'])->withTimestamps();
    }

  



    // ScopeActive produits

    /**

     */
    public function scopeActive($query)
    {
        // Retrieve only products with statut equal to 'active'
        return $query->where('statut', 'active');
    }



    // scope pour trier les produits par ordre alphabétique
    public function scopeAlphabetique($query)
    {
        return $query->orderBy('nom', 'asc');
    }
}
