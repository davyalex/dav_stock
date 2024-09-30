<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Inventaire extends Model
{
    use HasFactory , SoftDeletes;
    
    public $incrementing = false;

    protected $fillable = [
        'code',
        'date_inventaire',
        'user_id',
    ];

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->id = IdGenerator::generate(['table' => 'inventaires', 'length' => 10, 'prefix' =>
            mt_rand()]);
        });
    }

    public function produits() {
        return $this->belongsToMany(Produit::class)->withPivot(['stock_systeme','stock_physique','ecart' ,'etat' , 'observation'])->withTimestamps();
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    
}
