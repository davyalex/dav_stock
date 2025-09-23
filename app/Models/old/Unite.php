<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Unite extends Model
{
    use HasFactory ,  SoftDeletes;

    public $incrementing = false;

    protected $fillable = [
        'libelle',
        'abreviation',
        'created_at',
        'updated_at'
    ];

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->id = IdGenerator::generate(['table' => 'unites', 'length' => 10, 'prefix' =>
            mt_rand()]);
        });
    }


    public function produits(): BelongsToMany
    {
        return $this->belongsToMany(Produit::class ,'produit_unite')->withPivot(['quantite', 'prix', 'total'])->withTimestamps();
    }

   
}
