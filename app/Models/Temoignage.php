<?php

namespace App\Models;


use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
// use Cviebrock\EloquentSluggable\Sluggable;
use Spatie\MediaLibrary\InteractsWithMedia;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Temoignage extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    public $incrementing = false;

    protected $fillable = [
        'name',
        'description',
        'status',
    ];

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->id = IdGenerator::generate(['table' => 'temoignages', 'length' => 10, 'prefix' =>
            mt_rand()]);
        });
    }

  
}
