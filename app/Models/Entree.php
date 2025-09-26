<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Entree extends Model
{
    use HasFactory, SoftDeletes;

    public $incrementing = false;

    protected $fillable = [
        'code',
        'date_entree',
        'user_id',
    ];

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->id = IdGenerator::generate(['table' => 'entrees', 'length' => 10, 'prefix' =>
            mt_rand()]);
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function intrants()
    {
        return $this->belongsToMany(Intrant::class, 'intrant_entree', 'entree_id', 'intrant_id')
            ->withPivot('stock_disponible', 'stock_entree' , 'prix_achat')
            ->withTimestamps();
    }
}
