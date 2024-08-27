<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Menu extends Model
{
    use HasFactory , SoftDeletes;

    protected $fillable = [
        'libelle',
        'user_id',
        'date_menu',
    ];

 
    public function produits()
    {
        return $this->belongsToMany(Produit::class, 'menu_produit')->withTimestamps();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    
}
