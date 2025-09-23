<?php

namespace App\Models;

use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Fournisseur extends Model implements HasMedia
{
    use HasFactory, SoftDeletes,  InteractsWithMedia;

    public $incrementing = false;

    protected $fillable = [
        'nom',
        'adresse',
        'telephone',
        'email',
        'created_at',
        'updated_at'
    ];


    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->id = IdGenerator::generate(['table' => 'fournisseurs', 'length' => 10, 'prefix' =>
            mt_rand()]);
        });
    }

    public function achats() 
    {
        return $this->hasMany(Achat::class);
    }


    public function factures() 
    {
        return $this->hasMany(Facture::class);
    }

    
}
