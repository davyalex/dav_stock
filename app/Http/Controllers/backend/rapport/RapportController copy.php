<?php

namespace App\Http\Controllers\backend\rapport;

use Carbon\Carbon;
use App\Models\Achat;
use App\Models\Vente;
use App\Models\Caisse;
use App\Models\Depense;
use App\Models\Produit;
use App\Models\Categorie;
use App\Models\Inventaire;
use App\Models\ProduitVente;
use Illuminate\Http\Request;
use App\Models\ProduitSortie;
use App\Models\CategorieDepense;
use App\Models\InventaireProduit;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class RapportController extends Controller
{
    // rapport des ventes

    // public function vente(Request $request)
    // {
    //     try {
    //         $dateDebut = $request->input('date_debut');
    //         $dateFin = $request->input('date_fin');
    //         $caisseId = $request->input('caisse_id');
    //         $categorie = $request->input('categorie');
    //         // $periode = $request->input('periode');


    //         //Pour les vente bar et restaurant
    //         $query = Vente::with(['produits.categorie', 'plats.categorieMenu', 'caisse']);

    //         // pour la vente des plats menu
    //         $queryMenu = Vente::with(['plats.categorieMenu', 'caisse']);


    //         if ($dateDebut && $dateFin) {
    //             $query->whereBetween('date_vente', [$dateDebut, $dateFin]);
    //         } elseif ($dateDebut) {
    //             $query->where('date_vente', '>=', $dateDebut);
    //         } elseif ($dateFin) {
    //             $query->where('date_vente', '<=', $dateFin);
    //         }


    //         if ($caisseId) {
    //             $query->where('caisse_id', $caisseId);
    //         }


    //         // Application du filtre de periode
    //         // periode=> jour, semaine, mois, année
    //         // if ($request->filled('periode')) {
    //         //     $dates = match ($periode) {
    //         //         'jour' => [Carbon::today(), Carbon::today()],
    //         //         'semaine' => [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()],
    //         //         'mois' => [Carbon::now()->month, Carbon::now()->year], // Stocke mois et année pour `whereMonth`
    //         //         'annee' => Carbon::now()->year, // Stocke année pour `whereYear`
    //         //         default => null,
    //         //     };

    //         //     if ($dates) {
    //         //         if ($periode == 'jour') {
    //         //             $query->whereDate('date_vente', $dates[0]);
    //         //             $queryMenu->whereDate('date_vente', $dates[1]);
    //         //         } elseif ($periode == 'semaine') {
    //         //             $query->whereBetween('date_vente', $dates);
    //         //             $queryMenu->whereBetween('date_vente', $dates);
    //         //         } elseif ($periode == 'mois') {
    //         //             $query->whereMonth('date_vente', $dates[0])->whereYear('date_vente', $dates[1]);
    //         //             $queryMenu->whereMonth('date_vente', $dates[0])->whereYear('date_vente', $dates[1]);
    //         //         } elseif ($periode == 'annee') {
    //         //             $query->whereYear('date_vente', $dates);
    //         //             $queryMenu->whereYear('date_vente', $dates);
    //         //         }
    //         //     }
    //         // }



    //         $ventes = $query->get();




    //         // pour les produits restaurant et bar
    //         $produitsVendus = $ventes->flatMap(function ($vente) {
    //             return $vente->produits;
    //         })->groupBy('id')->map(function ($groupe) use ($categorie) {
    //             $produit = $groupe->first();
    //             if ($categorie && $produit->categorie->famille !== $categorie) {
    //                 return null;
    //             }


    //             return [
    //                 'details' => $groupe, // recuperer les details groupés par produit
    //                 'id' => $produit->id,
    //                 'code' => $produit->code,
    //                 'stock' => $produit->stock,
    //                 'designation' => $produit->nom,
    //                 'categorie' => $produit->categorie->name,
    //                 'famille' => $produit->categorie->famille,
    //                 'quantite_vendue' => $groupe->sum('pivot.quantite'),
    //                 'variante' => $groupe->first()->pivot->variante_id,
    //                 'prix_vente' => $groupe->first()->pivot->prix_unitaire,
    //                 'montant_total' => $groupe->sum(function ($item) {
    //                     return $item->pivot->quantite * $item->pivot->prix_unitaire;
    //                 }),
    //             ];
    //         })->filter()->values();



    //         $caisses = Caisse::all();
    //         $categorie = Categorie::whereNull('parent_id')->active()->orderBy('name', 'DESC')->get();


    //         return view('backend.pages.rapport.vente', compact( 'produitsVendus', 'caisses', 'dateDebut', 'dateFin', 'caisseId', 'categorie'));
    //     } catch (\Exception $e) {
    //         return back()->with('error', 'Une erreur s\'est produite : ' . $e->getMessage());
    //     }
    // }

    public function venteParCategorie(Request $request)
    {
        // Récupération des filtres
        $categorieId = $request->input('categorie_id');
        $caisseId = $request->input('caisse_id');
        $dateDebut = $request->input('date_debut');
        $dateFin = $request->input('date_fin');
        $periode = $request->input('periode');

        // Construction de la requête
        $query = Vente::with('produits.categorie');

        // Filtre caisse
        if ($caisseId) {
            $query->where('caisse_id', $caisseId);
        }

        // Filtre dates
        if ($dateDebut && $dateFin) {
            $query->whereBetween('date_vente', [$dateDebut, $dateFin]);
        } elseif ($dateDebut) {
            $query->where('date_vente', '>=', $dateDebut);
        } elseif ($dateFin) {
            $query->where('date_vente', '<=', $dateFin);
        }

        // Filtre période
        if ($periode) {
            if ($periode == 'jour') {
                $query->whereDate('date_vente', Carbon::today());
            } elseif ($periode == 'semaine') {
                $query->whereBetween('date_vente', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
            } elseif ($periode == 'mois') {
                $query->whereMonth('date_vente', Carbon::now()->month)
                    ->whereYear('date_vente', Carbon::now()->year);
            } elseif ($periode == 'annee') {
                $query->whereYear('date_vente', Carbon::now()->year);
            }
        }

        $ventes = $query->get();

        // Regroupement par catégorie parent avec filtre catégorie
        $categoriesParent = [];
        foreach ($ventes as $vente) {
            foreach ($vente->produits as $produit) {
                $parentCatObj = $produit->categorie && $produit->categorie->parent_id
                    ? $produit->categorie->parent
                    : $produit->categorie;

                $parentCatName = $parentCatObj ? $parentCatObj->name : 'Sans catégorie';
                $parentCatId = $parentCatObj ? $parentCatObj->id : null;

                // Filtre catégorie parent
                if ($categorieId && $parentCatId != $categorieId) {
                    continue;
                }

                if (!isset($categoriesParent[$parentCatName])) {
                    $categoriesParent[$parentCatName] = [
                        'produits' => [],
                        'total_ventes' => 0,
                    ];
                }
                $categoriesParent[$parentCatName]['produits'][] = [
                    'nom' => $produit->nom,
                    'quantite' => $produit->pivot->quantite,
                    'prix_unitaire' => $produit->pivot->prix_unitaire,
                    'total' => $produit->pivot->total,
                ];
                $categoriesParent[$parentCatName]['total_ventes'] += $produit->pivot->total;
            }
        }

        $montantTotalVente = 0;
        foreach ($categoriesParent as $infos) {
            $montantTotalVente += $infos['total_ventes'];
        }

        $caisses = Caisse::all();
        $categories = Categorie::whereNull('parent_id')->active()->orderBy('name', 'DESC')->get();

        return view('backend.pages.rapport.vente', compact('categoriesParent', 'caisses', 'categories' , 'montantTotalVente'));
    }

    public function venteParProduit(Request $request)
    {
        $produitId = $request->input('produit_id');
        $dateDebut = $request->input('date_debut');
        $dateFin = $request->input('date_fin');
        $caisseId = $request->input('caisse_id');
        $periode = $request->input('periode');
        $classement = $request->input('classement');

        $query = ProduitVente::with(['produit', 'vente', 'vente.caisse']);

        // Filtres
        if ($produitId) {
            $query->where('produit_id', $produitId);
        }
        if ($caisseId) {
            $query->whereHas('vente', function($q) use ($caisseId) {
                $q->where('caisse_id', $caisseId);
            });
        }
        if ($dateDebut && $dateFin) {
            $query->whereHas('vente', function($q) use ($dateDebut, $dateFin) {
                $q->whereBetween('date_vente', [$dateDebut, $dateFin]);
            });
        } elseif ($dateDebut) {
            $query->whereHas('vente', function($q) use ($dateDebut) {
                $q->where('date_vente', '>=', $dateDebut);
            });
        } elseif ($dateFin) {
            $query->whereHas('vente', function($q) use ($dateFin) {
                $q->where('date_vente', '<=', $dateFin);
            });
        }
        if ($periode) {
            $query->whereHas('vente', function($q) use ($periode) {
                if ($periode == 'jour') {
                    $q->whereDate('date_vente', Carbon::today());
                } elseif ($periode == 'semaine') {
                    $q->whereBetween('date_vente', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
                } elseif ($periode == 'mois') {
                    $q->whereMonth('date_vente', Carbon::now()->month)
                      ->whereYear('date_vente', Carbon::now()->year);
                } elseif ($periode == 'annee') {
                    $q->whereYear('date_vente', Carbon::now()->year);
                }
            });
        }

        $ventesProduit = $query->get();

        // Regroupement par produit
        $produitsGroupes = $ventesProduit->groupBy('produit_id')->map(function($items, $produitId) use ($dateDebut, $dateFin) {
            $produit = $items->first()->produit;
            $prix_unitaire = $items->first()->prix_unitaire;
            $quantite_vendue = $items->sum('quantite');

            // Quantité reçue (ajustement produit)
            $ajustementQuery = DB::table('ajustement_produit')
                ->where('produit_id', $produitId)
                ->where('type_ajustement', 'ajouter');
            if ($dateDebut) $ajustementQuery->whereDate('created_at', '>=', $dateDebut);
            if ($dateFin) $ajustementQuery->whereDate('created_at', '<=', $dateFin);
            $quantite_recue = $ajustementQuery->sum('stock_ajuste');

            // Quantité restante avant vente = quantité reçue
            $stock_avant = $quantite_recue;

            // Quantité restante après vente = reçue - vendue
            $stock_apres = $quantite_recue - $quantite_vendue;

            // Montant total
            $montant_total = $quantite_vendue * $prix_unitaire;

            return [
                'produit' => $produit,
                'prix_unitaire' => $prix_unitaire,
                'stock_avant' => $stock_avant,
                'quantite_recue' => $quantite_recue,
                'quantite_vendue' => $quantite_vendue,
                'stock_apres' => $stock_apres,
                'montant_total' => $montant_total,
            ];
        });

        // Classement
        if ($classement == 'plus_vendu') {
            $produitsGroupes = $produitsGroupes->sortByDesc('quantite_vendue');
        } elseif ($classement == 'moins_vendu') {
            $produitsGroupes = $produitsGroupes->sortBy('quantite_vendue');
        }

        $totalVendu = $produitsGroupes->sum('montant_total');
        $produits = Produit::active()->get();
        $caisses = Caisse::all();

        return view('backend.pages.rapport.produit', [
            'produitsGroupes' => $produitsGroupes,
            'produits' => $produits,
            'caisses' => $caisses,
            'totalVendu' => $totalVendu,
        ]);
    }






    // public function historique(Request $request)
    // {
    //     try {


    //         $request->validate([
    //             'produit' => '',
    //             'dateDebut' => 'nullable',
    //             'dateFin' => 'nullable',
    //             'type' => '',
    //         ]);

    //         // recuperer les produit bar et restaurant
    //         $data_produit = Produit::active()->whereHas('categorie', function ($q) {
    //             $q->whereIn('famille', ['restaurant', 'bar']);
    //         })->get();

    //         // recuperer les request
    //         $produit = request('produit');
    //         $dateDebut = request('date_debut');
    //         $dateFin = request('date_fin');
    //         $type = request('type'); // vente, achat, inventaire , sortie

    //         $vente = [];
    //         $achat = [];
    //         $inventaire = [];
    //         $sortie = [];

    //         // vente
    //         if ($type == 'vente') {
    //             $vente = ProduitVente::with(['vente', 'variante', 'produit'])
    //                 ->where('produit_id', $produit)
    //                 ->orderBy('created_at', 'DESC');

    //             // Filtrer en fonction des dates
    //             if ($dateDebut && $dateFin) {
    //                 $vente->whereHas('vente', function ($query) use ($dateDebut, $dateFin) {
    //                     $query->whereBetween('date_vente', [$dateDebut, $dateFin]);
    //                 });
    //             } elseif ($dateDebut) {
    //                 $vente->whereHas('vente', function ($query) use ($dateDebut) {
    //                     $query->whereDate('date_vente', $dateDebut);
    //                 });
    //             } elseif ($dateFin) {
    //                 $vente->whereHas('vente', function ($query) use ($dateFin) {
    //                     $query->whereDate('date_vente', $dateFin);
    //                 });
    //             }

    //             // Récupération des données
    //             $vente = $vente->get();
    //         }


    //         // achat
    //         if ($type == 'achat') {
    //             $achat = Achat::with('produit')
    //                 ->where('produit_id', $produit)
    //                 ->orderBy('created_at', 'DESC');

    //             // Filtrer en fonction des dates
    //             if ($dateDebut && $dateFin) {
    //                 $achat->whereBetween('date_achat', [$dateDebut, $dateFin]);
    //             } elseif ($dateDebut) {
    //                 $achat->whereDate('date_achat', $dateDebut);
    //             } elseif ($dateFin) {
    //                 $achat->whereDate('date_achat', $dateFin);
    //             }

    //             // Récupération des données
    //             $achat = $achat->get();
    //         }


    //         // inventaire
    //         if ($type == 'inventaire') {
    //             $inventaire = InventaireProduit::with(['inventaire', 'produit'])
    //                 ->where('produit_id', $produit)
    //                 ->orderBy('created_at', 'DESC');

    //             // Filtrer en fonction des dates
    //             if ($dateDebut && $dateFin) {
    //                 $inventaire->whereHas('inventaire', function ($query) use ($dateDebut, $dateFin) {
    //                     $query->whereBetween('date_inventaire', [$dateDebut, $dateFin]);
    //                 });
    //             } elseif ($dateDebut) {
    //                 $inventaire->whereHas('inventaire', function ($query) use ($dateDebut) {
    //                     $query->whereDate('date_inventaire', $dateDebut);
    //                 });
    //             } elseif ($dateFin) {
    //                 $inventaire->whereHas('inventaire', function ($query) use ($dateFin) {
    //                     $query->whereDate('date_inventaire', $dateFin);
    //                 });
    //             }

    //             // Récupération des données
    //             $inventaire = $inventaire->get();
    //         }



    //         // inventaire
    //         if ($type == 'sortie') {
    //             $sortie = ProduitSortie::with(['sortie', 'produit'])
    //                 ->where('produit_id', $produit)
    //                 ->orderBy('created_at', 'DESC');

    //             // Filtrer en fonction des dates
    //             if ($dateDebut && $dateFin) {
    //                 $sortie->whereHas('sortie', function ($query) use ($dateDebut, $dateFin) {
    //                     $query->whereBetween('date_sortie', [$dateDebut, $dateFin]);
    //                 });
    //             } elseif ($dateDebut) {
    //                 $sortie->whereHas('sortie', function ($query) use ($dateDebut) {
    //                     $query->whereDate('date_sortie', $dateDebut);
    //                 });
    //             } elseif ($dateFin) {
    //                 $sortie->whereHas('sortie', function ($query) use ($dateFin) {
    //                     $query->whereDate('date_sortie', $dateFin);
    //                 });
    //             }

    //             // Récupération des données
    //             $sortie = $sortie->get();
    //         }


    //         // dd($sortie->toArray());


    //         return view('backend.pages.rapport.historique', compact('data_produit', 'vente', 'achat', 'inventaire', 'sortie'));
    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'status' => 'error',
    //             'message' => 'Une erreur est survenue lors du chargement de l\'historique : ' . $e->getMessage()
    //         ], 500);
    //     }
    // }
}
