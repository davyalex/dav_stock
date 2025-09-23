<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Format extends Model
{
    use HasFactory,  SoftDeletes;

    public $incrementing = false;

    protected $fillable = [
        'libelle',
        'abreviation',
        'created_at',
        'updated_at'
    ];

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->id = IdGenerator::generate(['table' => 'formats', 'length' => 10, 'prefix' =>
            mt_rand()]);
        });
    }

    public function achats() // BAR ? RESTAURANT
    {
        return $this->hasMany(Achat::class);
    }
}
