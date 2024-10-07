<?php

namespace App\Http\Controllers\backend\rapport;

use App\Models\Vente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class RapportController extends Controller
{
    //
    public function categorie(Request $request)
    {
        try {
            // Récupérer uniquement les catégories 'bar' et 'menu'
            $categories = DB::table('categories')
                ->whereIn('name', ['Bar', 'Menu'])
                ->get();

            // Ajouter les catégories à la vue
            $data['categories'] = $categories;
            // Récupération des chiffres d'affaires par catégorie
            $chiffresAffaires = DB::table('ventes')
                ->join('produit_vente', 'ventes.id', '=', 'produit_vente.vente_id')
                ->join('produits', 'produit_vente.produit_id', '=', 'produits.id')
                ->join('categories', 'produits.categorie_id', '=', 'categories.id')
                ->select('categories.name as categorie', DB::raw('SUM(ventes.montant_total) as chiffre_affaires'))
                ->groupBy('categories.id', 'categories.name');

            // Appliquer les filtres si présents
            if ($request->filled('categorie')) {
                $chiffresAffaires->where('categories.id', $request->categorie);
            }
            
            if ($request->filled('date_debut') && $request->filled('date_fin')) {
                $chiffresAffaires->whereBetween('ventes.created_at', [$request->date_debut, $request->date_fin]);
            } elseif ($request->filled('date_debut')) {
                $chiffresAffaires->where('ventes.created_at', '>=', $request->date_debut);
            } elseif ($request->filled('date_fin')) {
                $chiffresAffaires->where('ventes.created_at', '<=', $request->date_fin);
            }

            // Exécuter la requête et obtenir les résultats
            $resultats = $chiffresAffaires->get();


          return view('backend.pages.rapport.categorie', compact('resultats', 'categories'));
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Une erreur est survenue lors de la récupération des chiffres d\'affaires : ' . $e->getMessage()
            ], 500);
        }
    }



    
}
