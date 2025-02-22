<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventaireProduit extends Model
{
    use HasFactory;

    protected $table = 'inventaire_produit';

    public function inventaire()
    {
        return $this->belongsTo(Inventaire::class, 'inventaire_id');
    }

    public function produit()
    {
        return $this->belongsTo(Produit::class, 'produit_id');
    }
}
