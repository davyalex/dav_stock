<?php

namespace App\Models;

use Spatie\Image\Enums\Fit;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\MediaCollections\Models\Media;


class Setting extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    public $incrementing = false;

    protected $fillable = [
        //socials networks link
        'facebook_link',
        'instagram_link',
        'twitter_link',
        'linkedin_link',
        'tiktok_link',

        //infos application
        'projet_title', //nom du projet
        'projet_description', //description du projet
        'phone1',
        'phone1',
        'phone2',
        'phone3',
        'email1',
        'email2',
        'localisation',
        'google_maps',
        'siege_social',

        //security
        'mode_maintenance',
    ];

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->id = IdGenerator::generate(['table' => 'settings', 'length' => 10, 'prefix' =>
            mt_rand()]);
        });
    }

    // public function registerMediaConversions(Media $media = null): void
    // {
    //     $this
    //         ->addMediaConversion('preview')
    //         ->fit(Fit::Contain, 300, 300)
    //         ->nonQueued();
    // }



}
