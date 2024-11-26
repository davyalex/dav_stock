<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Menu extends Model
{
    use HasFactory, SoftDeletes;
    public $incrementing = false;

    protected $fillable = [
        'libelle',
        'user_id',
        'date_menu',
    ];


    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->id = IdGenerator::generate(['table' => 'menus', 'length' => 10, 'prefix' =>
            mt_rand()]);
        });
    }

    //MENU
    public function plats()
    {
        return $this->belongsToMany(Plat::class, 'menu_plat')
            ->withPivot('categorie_menu_id')
            ->withTimestamps();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    // MENU



}
