<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProduitVente extends Model
{
    use HasFactory;

    protected $table = 'produit_vente';

    public function vente()
    {
        return $this->belongsTo(Vente::class, 'vente_id');
    }

    public function produit()
    {
        return $this->belongsTo(Produit::class, 'produit_id');
    }

    public function variante()
    {
        return $this->belongsTo(Variante::class, 'variante_id');
    }

}
