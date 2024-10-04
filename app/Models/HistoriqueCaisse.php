<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class HistoriqueCaisse extends Model
{
    use HasFactory;

    public $incrementing = false;


    protected $fillable = [
        'user_id',
        'caisse_id',
        'date_ouverture',
        'date_fermeture',
        'created_at',
        'updated_at'
    ];




    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->id = IdGenerator::generate(['table' => 'historique_caisses', 'length' => 10, 'prefix' =>
            mt_rand()]);
        });
    }


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function caisse()
    {
        return $this->belongsTo(Caisse::class, 'caisse_id');
    }
}
