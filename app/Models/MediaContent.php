<?php

namespace App\Models;

use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Spatie\MediaLibrary\InteractsWithMedia;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MediaContent extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia, sluggable;


    public $incrementing = false;

    protected $fillable = [
        'title',
        'slug',
        'status',
        'url',
        'media_categories_id',
    ];

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->id = IdGenerator::generate(['table' => 'media_contents', 'length' => 10, 'prefix' =>
            mt_rand()]);
        });
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }


    /**
     * Get the user that owns the BlogContent
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function media_category(): BelongsTo
    {
        return $this->belongsTo(MediaCategory::class, 'media_categories_id', 'id');
    }
}
