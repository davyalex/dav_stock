<?php

namespace App\Models;

use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Spatie\MediaLibrary\InteractsWithMedia;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BlogCategory extends Model implements HasMedia
{
    use HasFactory , InteractsWithMedia , sluggable;

    public $incrementing = false;

    protected $fillable = [
        'name',
        'slug',
        'status',
        'position',
    ];

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->id = IdGenerator::generate(['table' => 'blog_categories', 'length' => 10, 'prefix' =>
            mt_rand()]);
        });
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    /**
     * Get all of the comments for the BlogCategory
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function blog_content(): HasMany
    {
        return $this->hasMany(BlogContent::class);
    }
}
