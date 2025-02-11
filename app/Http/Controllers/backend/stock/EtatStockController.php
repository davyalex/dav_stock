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
            $filter = request('filter');
            $statut = request('statut'); // Alerte ou Normal

            $produits = Produit::with(['categorie', 'achats',])
                ->whereHas('categorie', function ($query) {
                    $query->whereIn('famille', ['bar', 'restaurant']);
                })
                ->when($filter, function ($query) use ($filter) {
                    return $query->withWhereHas('typeProduit', fn($q) => $q->where('type', $filter));
                })
                ->when($statut === 'alerte', function ($query) {
                    return $query->where('stock', '<=', 'stock_alerte');
                })
                ->get();




            // dd($produits->toArray());
            return view('backend.pages.stock.etat-stock.index', compact('produits'));
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Une erreur est survenue lors de la récupération des données.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
