<?php

namespace App\Http\Controllers\backend\rapport;

use App\Models\Vente;
use App\Models\Depense;
use App\Models\Produit;
use App\Models\Categorie;
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




    public function produits(Request $request)
    {
        try {
            // $query = Produit::with(['categorie', 'ventes', 'achats' => function ($query) {
            //     $query->where('statut', 'active')->orderBy('created_at', 'asc');
            // }])
            // ->has('ventes')  // Ajoute cette ligne pour préciser les produits avec au moins une vente
            // ->withCount('ventes')
            // ->withSum('ventes as quantite_vendue', 'produit_vente.quantite')
            // ->withSum('ventes as montant_total_ventes', DB::raw('produit_vente.quantite * produit_vente.prix_unitaire'));



            //     ->select(
            //         'produits.id',
            //         'produits.nom',
            //         'categories.name as categorie',
            //         DB::raw('SUM(produit_vente.quantite) as quantite_vendue'),
            //         DB::raw('SUM(produit_vente.quantite * produit_vente.prix_unitaire) as montant_total_ventes')
            //     )
            //     ->join('categories', 'produits.categorie_id', '=', 'categories.id')
            //     ->leftJoin('produit_vente', 'produits.id', '=', 'produit_vente.produit_id')
            //     ->leftJoin('ventes', 'produit_vente.vente_id', '=', 'ventes.id')
            //     ->whereIn('categories.famille', ['menu', 'bar'])
            //     ->groupBy('produits.id', 'produits.nom', 'categories.name');

            // // Ajout du stock disponible pour les produits de type 'bar'
            // $query->addSelect(DB::raw('CASE WHEN categories.famille = "bar" THEN produits.stock ELSE NULL END as stock_disponible'));

            // // Application des filtres
            // if ($request->filled('categorie')) {
            //     $query->whereHas('categorie', function($q) use ($request) {
            //         $q->where('famille', $request->categorie);
            //     });
            // }

            // if ($request->filled(['date_debut', 'date_fin'])) {
            //     $query->whereHas('ventes', function($q) use ($request) {
            //         $q->whereBetween('created_at', [$request->date_debut, $request->date_fin]);
            //     });
            // } elseif ($request->filled('date_debut')) {
            //     $query->whereHas('ventes', function($q) use ($request) {
            //         $q->where('created_at', '>=', $request->date_debut);
            //     });
            // } elseif ($request->filled('date_fin')) {
            //     $query->whereHas('ventes', function($q) use ($request) {
            //         $q->where('created_at', '<=', $request->date_fin);
            //     });
            // } else {
            //     $query->whereHas('categorie', function($q) {
            //         $q->whereIn('famille', ['bar', 'menu']);
            //     });
            // }

            // $produits = $query->get();




            $query = Produit::with(['categorie', 'ventes', 'achats' => function ($query) {
                $query->where('statut', 'active')->orderBy('created_at', 'asc');
            }])
                ->has('ventes')  // Précise les produits avec au moins une vente
                ->withCount('ventes')
                ->withSum('ventes as quantite_vendue', 'produit_vente.quantite')
                ->withSum('ventes as montant_total_ventes', DB::raw('produit_vente.quantite * produit_vente.prix_unitaire'));

            // Application des filtres
            if ($request->filled('categorie')) {
                $query->whereHas('categorie', function ($q) use ($request) {
                    $q->where('famille', $request->categorie);
                });
            }

            if ($request->filled(['date_debut', 'date_fin'])) {
                $query->whereHas('ventes', function ($q) use ($request) {
                    $q->whereBetween('ventes.created_at', [$request->date_debut, $request->date_fin]); // Préciser la table 'ventes'
                });
            } elseif ($request->filled('date_debut')) {
                $query->whereHas('ventes', function ($q) use ($request) {
                    $q->where('ventes.created_at', '>=', $request->date_debut); // Préciser la table 'ventes'
                });
            } elseif ($request->filled('date_fin')) {
                $query->whereHas('ventes', function ($q) use ($request) {
                    $q->where('ventes.created_at', '<=', $request->date_fin); // Préciser la table 'ventes'
                });
            } else {
                $query->whereHas('categorie', function ($q) {
                    $q->whereIn('famille', ['bar', 'menu']);
                });
            }

            $produits = $query->get();

            // dd($produits->toArray());
            // Récupération des catégories pour le filtre

            $data_categorie = Categorie::whereNull('parent_id')->with('children', fn($q) => $q->OrderBy('position', 'ASC'))->withCount('children')
                ->whereIn('type', ['bar', 'menu'])
                ->OrderBy('position', 'ASC')->get();

            $categorie_famille = Categorie::whereNull('parent_id')->whereIn('type', ['bar', 'menu'])->get();

            return view('backend.pages.rapport.produit', compact('produits', 'data_categorie', 'categorie_famille'));
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'erreur',
                'message' => 'Une erreur est survenue lors de la récupération des données des produits : ' . $e->getMessage()
            ], 500);
        }
    }


public function exploitation(Request $request)
{
    try {
        $venteQuery = Vente::query();
        $depenseQuery = Depense::query();
        
        // Application des filtres de date
        if ($request->filled(['date_debut', 'date_fin'])) {
            $venteQuery->whereBetween('created_at', [$request->date_debut, $request->date_fin]);
            $depenseQuery->whereBetween('date_depense', [$request->date_debut, $request->date_fin]); 
        } elseif ($request->filled('date_debut')) {
            $venteQuery->where('created_at', '>=', $request->date_debut);
            $depenseQuery->where('date_depense', '>=', $request->date_debut); 
        } elseif ($request->filled('date_fin')) {
            $venteQuery->where('created_at', '<=', $request->date_fin);
            $depenseQuery->where('date_depense', '<=', $request->date_fin); 
        }
        
        $totalVentes = $venteQuery->sum('montant_total');
        $totalDepenses = $depenseQuery->sum('montant');
        
        $benefice = $totalVentes - $totalDepenses;
        $ratio = $totalVentes > 0 ? ($benefice / $totalVentes) * 100 : 0;
        

        return view('backend.pages.rapport.exploitation', compact('totalVentes', 'totalDepenses', 'benefice', 'ratio'));
    } catch (\Exception $e) {
        return response()->json([
            'status' => 'erreur',
            'message' => 'Une erreur est survenue lors du calcul du compte d\'exploitation : ' . $e->getMessage()
        ], 500);
    }
}
}
