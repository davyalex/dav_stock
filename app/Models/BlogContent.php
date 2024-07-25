<?php

namespace App\Models;

use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Spatie\MediaLibrary\InteractsWithMedia;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BlogContent extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia, sluggable;


    public $incrementing = false;

    protected $fillable = [
        'title',
        'slug',
        'resume', //summary of description
        'description',
        'status',
        'blog_categories_id',
    ];

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->id = IdGenerator::generate(['table' => 'blog_contents', 'length' => 10, 'prefix' =>
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
    public function blog_category(): BelongsTo
    {
        return $this->belongsTo(BlogCategory::class , 'blog_categories_id' , 'id' )->where('status' , 'active');
    }

   
}
