<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ClotureCaisse extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'cloture_caisses';
    public $incrementing = false;
    protected $fillable = [
        'montant_total',
        'date_cloture',
        'user_id',
        'caisse_id',
    ];
    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->id = IdGenerator::generate(['table' => 'cloture_caisses', 'length' => 10, 'prefix' =>
            mt_rand()]);
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function caisse()
    {
        return $this->belongsTo(Caisse::class);
    }
}
