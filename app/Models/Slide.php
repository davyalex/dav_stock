<?php

namespace App\Models;


use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Spatie\MediaLibrary\InteractsWithMedia;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Slide extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia ;

    public $incrementing = false;

    protected $fillable = [
        'title',
        'subtitle',
        'btn_name',
        'btn_url',
        'btn_status',
        'status',
    ];

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->id = IdGenerator::generate(['table' => 'slides', 'length' => 10, 'prefix' =>
            mt_rand()]);
        });
    }

    // public function sluggable(): array
    // {
    //     return [
    //         'slug' => [
    //             'source' => 'title'
    //         ]
    //     ];
    // }
}