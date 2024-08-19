<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ajustement extends Model
{
    use HasFactory, SoftDeletes;

    public $incrementing = false;

    protected $fillable = [
        'code',
        'achat_id',
        'mouvement', //retirer ? ajouter
        'stock_actuel', // stock de achat
        'stock_ajustement',
        'user_id'
    ];

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->id = IdGenerator::generate(['table' => 'ajustements', 'length' => 10, 'prefix' =>
            mt_rand()]);
        });
    }




    public function user() // BAR ? RESTAURANT
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function achat() 
    {
        return $this->belongsTo(Achat::class, 'achat_id');
    }
}
