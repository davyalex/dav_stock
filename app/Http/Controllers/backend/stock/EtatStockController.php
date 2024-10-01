<?php

namespace App\Http\Controllers\backend\stock;

use App\Models\Produit;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EtatStockController extends Controller
{
    public function index()
    {
        try {
            $produits = Produit::with('categorie')->get();
            return view('backend.pages.stock.etat-stock.index', compact('produits'));
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Une erreur est survenue lors de la récupération des données.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
