<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProduitSortie extends Model
{
    use HasFactory;

    protected $table = 'produit_sortie';

    public function sortie()
    {
        return $this->belongsTo(Sortie::class, 'sortie_id');
    }

    public function produit()
    {
        return $this->belongsTo(Produit::class, 'produit_id');
    }
}
