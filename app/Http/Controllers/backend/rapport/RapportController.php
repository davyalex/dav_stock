<?php

namespace App\Http\Controllers\backend\rapport;

use Carbon\Carbon;
use App\Models\Achat;
use App\Models\Vente;
use App\Models\Caisse;
use App\Models\Depense;
use App\Models\Produit;
use App\Models\Categorie;
use App\Models\ProduitVente;
use Illuminate\Http\Request;
use App\Models\ProduitSortie;
use App\Models\CategorieDepense;
use App\Models\InventaireProduit;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class RapportController extends Controller
{
    //NO USE
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

    //NO USE    
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




            $query = Produit::with(['categorie', 'ventes', 'achats'])
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

            $produits = $query->orderBy();

            // dd($produits->toArray());
            // Récupération des catégories pour le filtre

            $data_categorie = Categorie::whereNull('parent_id')->with('children', fn($q) => $q->OrderBy('position', 'ASC'))->withCount('children')
                ->whereIn('type', ['bar', 'menu'])
                ->OrderBy('position', 'DESC')->get();

            $categorie_famille = Categorie::whereNull('parent_id')->whereIn('type', ['bar', 'menu'])->get();

            return view('backend.pages.rapport.produit', compact('produits', 'data_categorie', 'categorie_famille'));
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'erreur',
                'message' => 'Une erreur est survenue lors de la récupération des données des produits : ' . $e->getMessage()
            ], 500);
        }
    }


    // public function exploitation(Request $request)
    // {
    //     try {
    //         $venteQuery = Vente::query();
    //         $depenseQuery = Depense::query();

    //         // Application des filtres de date
    //         if ($request->filled(['date_debut', 'date_fin'])) {
    //             $venteQuery->whereBetween('created_at', [$request->date_debut, $request->date_fin]);
    //             $depenseQuery->whereBetween('date_depense', [$request->date_debut, $request->date_fin]);
    //         } elseif ($request->filled('date_debut')) {
    //             $venteQuery->where('created_at', '>=', $request->date_debut);
    //             $depenseQuery->where('date_depense', '>=', $request->date_debut);
    //         } elseif ($request->filled('date_fin')) {
    //             $venteQuery->where('created_at', '<=', $request->date_fin);
    //             $depenseQuery->where('date_depense', '<=', $request->date_fin);
    //         }

    //         $totalVentes = $venteQuery->sum('montant_total');
    //         $totalDepenses = $depenseQuery->sum('montant');

    //         $benefice = $totalVentes - $totalDepenses;
    //         $ratio = $totalVentes > 0 ? ($benefice / $totalVentes) * 100 : 0;


    //         return view('backend.pages.rapport.exploitation', compact('totalVentes', 'totalDepenses', 'benefice', 'ratio'));
    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'status' => 'erreur',
    //             'message' => 'Une erreur est survenue lors du calcul du compte d\'exploitation : ' . $e->getMessage()
    //         ], 500);
    //     }
    // }


    /**
     * Generate an exploitation report based on sales and expenses.
     *
     * This function retrieves categories of expenses and creates base queries
     * for sales and expenses. It applies date filters, filters expenses by category,
     * calculates sales and expenses totals, and computes benefits and ratios.
     * Finally, it prepares data to be sent to the exploitation view for rendering.
     *
     * @param Request $request The HTTP request containing optional filters such as
     *                         'date_debut', 'date_fin', and 'categorie_depense'.
     *
     * @return \Illuminate\View\View|string Returns a view with exploitation data or
     *                                      an error message in case of an exception.
     */

    public function exploitation(Request $request)
    {
        try {
            // 1. Récupération des catégories de dépense
            $categories_depense = CategorieDepense::with('libelleDepenses')->orderBy('libelle')->get(); //categorie pour recuperer les libelles de cat_depense selectionner
            $categories = CategorieDepense::with('libelleDepenses')->orderBy('libelle')->get(); // pour le filtre des cat_depense

            // 2. Création des requêtes de base pour les ventes et les dépenses
            $moisEnCours = date('m');
            $venteQuery = Vente::query()->whereRaw("MONTH(ventes.created_at) = $moisEnCours");
            $depenseQuery = Depense::query()->whereRaw("MONTH(date_depense) = $moisEnCours");

            // 3. Application des filtres de date
            // Formatage des dates
            $dateDebut = $request->filled('date_debut') ? Carbon::parse($request->date_debut)->format('Y-m-d') : null;
            $dateFin = $request->filled('date_fin') ? Carbon::parse($request->date_fin)->format('Y-m-d') : null;

            // Application des filtres de date
            if ($dateDebut && $dateFin) {
                $venteQuery->whereBetween('ventes.created_at', [$dateDebut, $dateFin]);
                $depenseQuery->whereBetween('date_depense', [$dateDebut, $dateFin]);
            } elseif ($dateDebut) {
                $venteQuery->where('ventes.created_at', '=', $dateDebut);
                $depenseQuery->where('date_depense', '=', $dateDebut);
            } elseif ($dateFin) {
                $venteQuery->where('ventes.created_at', '=', $dateFin);
                $depenseQuery->where('date_depense', '=', $dateFin);
            }
            // else{
            //     // recuperer pour le mois en cours
            //     $venteQuery->whereRaw("MONTH(ventes.created_at) = $moisEnCours");
            //     $depenseQuery->whereRaw("MONTH(date_depense) = $moisEnCours");
            // }


            // 4. Filtrage par catégorie de dépense
            if ($request->filled('categorie_depense')) {
                $categories_depense = $categories_depense->where('id', $request->categorie_depense);
                $depenseQuery->where('categorie_depense_id', $request->categorie_depense);
                $categories = CategorieDepense::with('libelleDepenses')->orderBy('libelle')->get(); // si une categorie on affiche toute les categories
            }

            // 5. Somme des dépenses par libellé et catégorie
            $depenses = $depenseQuery->with(['libelle_depense', 'categorie_depense'])
                ->select('libelle_depense_id', 'categorie_depense_id', DB::raw('SUM(montant) as total_montant'))
                ->groupBy('libelle_depense_id', 'categorie_depense_id')
                ->get();

            // 6. Groupement des dépenses par catégorie
            $depensesParCategorie = $depenses->groupBy('categorie_depense.libelle');

            // 7. Total des ventes
            // $totalVentes = $venteQuery->sum('montant_total');

            // 8. Calcul des ventes par famille (bar et menu) avec la table pivot
            $ventesParFamille = $venteQuery->with('produits.categorie')
                ->select('categories.famille', DB::raw('SUM(produit_vente.quantite * produit_vente.prix_unitaire) as total_ventes'))
                ->join('produit_vente', 'ventes.id', '=', 'produit_vente.vente_id')
                ->join('produits', 'produit_vente.produit_id', '=', 'produits.id')
                ->join('categories', 'produits.categorie_id', '=', 'categories.id')
                ->whereIn('categories.famille', ['bar', 'menu'])
                ->groupBy('categories.famille')
                ->get()
                ->pluck('total_ventes', 'famille')
                ->toArray();


            // Calcul du montant total des plats vendus
            $ventesMenu = $venteQuery->with('plats.categorieMenu')
                ->select(DB::raw('SUM(plat_vente.quantite * plat_vente.prix_unitaire) as total_ventes'))
                ->join('plat_vente', 'ventes.id', '=', 'plat_vente.vente_id')
                ->join('plats', 'plat_vente.plat_id', '=', 'plats.id')
                ->get()
                ->mapWithKeys(function ($item) {
                    return ['vente_menu' => $item->total_ventes]; // Remplacez 'alias_desire' par votre clé
                })
                ->toArray();

            // montant des ventes realisés
            $venteBar = $ventesParFamille['bar'] ?? 0;
            $venteMenu = $ventesParFamille['menu'] ?? 0;
            $ventePlatMenu = $ventesMenu['vente_menu'] ?? 0;

            // total vente
            $totalVentes = $venteBar + $venteMenu + $ventePlatMenu;

            // 9. Calcul des totaux et ratios
            $totalDepenses = $depenses->sum('total_montant');
            $benefice = $totalVentes - $totalDepenses;
            $ratio = $totalVentes > 0 ? ($benefice / $totalVentes) * 100 : 0;

            // 10. Calcul benefice et du ratio pour chaque famille
            $beneficeBar = $venteBar - $totalDepenses;
            $beneficeMenu = $venteMenu - $totalDepenses;

            $ratioBar = $venteBar > 0 ? ($beneficeBar / $venteBar) * 100 : 0;
            $ratioMenu = $venteMenu > 0 ? ($beneficeMenu / $venteMenu) * 100 : 0;

            // 11. Préparation des données pour la vue
            $dataParFamille = [
                'Bar' => [
                    'ventes' => $venteMenu,
                    'benefice' => $beneficeBar,
                    'ratio' => $ratioMenu
                ],
                'Restaurant' => [
                    'ventes' => $venteBar,
                    'benefice' => $beneficeMenu,
                    'ratio' => $ratioBar
                ],

                'Menu' => [
                    'ventes' => $ventePlatMenu,
                    // 'benefice' => $beneficeBar,
                    // 'ratio' => $ratioBar
                ],
            ];
            // Concaténation des deux résultats
            // $dataParFamille = array_merge($ventesParFamille, $ventesMenu);

            // Résultat final
            // return $resultatFinal;
            // dd($totalVentes);



            return view('backend.pages.rapport.exploitation', compact('totalVentes', 'totalDepenses', 'benefice', 'ratio', 'categories_depense', 'depensesParCategorie', 'dataParFamille', 'categories'));
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Affiche le détail des achats ou des dépenses d'une catégorie de dépense
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function detail(Request $request)
    {
        try {
            $dateDebut = $request->input('date_debut');
            $dateFin = $request->input('date_fin');
            $categorieDepense = $request->input('categorie_depense');  // ID de la catégorie de depense selectionnée
            $libelleDepense = $request->input('libelle_depense');

            $produitId = $request->input('produitId'); // Id du produit pour recuperer tous les achats du produits


            // Vérification de la catégorie de dépense
            $categorieDepenseExiste = CategorieDepense::where('id', $categorieDepense)->first();

            if ($categorieDepenseExiste->slug === 'achats') {
                // Récupération des produits avec des achats dans la période spécifiée
                $produits = Produit::whereHas('achats', function ($query) use ($dateDebut, $dateFin) {
                    if ($dateDebut && $dateFin) {
                        $query->whereBetween('date_achat', [$dateDebut, $dateFin]);
                    } elseif ($dateDebut) {
                        $query->where('date_achat', '>=', $dateDebut);
                    } elseif ($dateFin) {
                        $query->where('date_achat', '<=', $dateFin);
                    }
                })->with(['achats' => function ($query) use ($dateDebut, $dateFin) {
                    if ($dateDebut && $dateFin) {
                        $query->whereBetween('date_achat', [$dateDebut, $dateFin]);
                    } elseif ($dateDebut) {
                        $query->where('date_achat', '>=', $dateDebut);
                    } elseif ($dateFin) {
                        $query->where('date_achat', '<=', $dateFin);
                    }
                }])->get()
                    ->groupBy('id');

                $produitsGroupes = $produits->map(function ($groupe) {
                    $premierProduit = $groupe->first();
                    return [
                        'id' => $premierProduit->id,
                        'nom' => $premierProduit->nom,
                        'stock_restant' => $premierProduit->stock,
                        'achats' => $groupe->flatMap->achats,
                        'quantite_achat' => $groupe->flatMap->achats->sum('quantite_stocke'),

                        'prix_total_format' => number_format($groupe->flatMap->achats->sum(function ($achat) {
                            return $achat->prix_total_format;
                        }), 0, ',', ' ') . ' FCFA'
                    ];
                })->values();

                return view('backend.pages.rapport.detail_achat', compact('produitsGroupes', 'dateDebut', 'dateFin'));
            } else {
                // Récupération des dépenses de la catégorie sélectionnée dans la période spécifiée
                $depenses = Depense::where('categorie_depense_id', $categorieDepense)
                    ->where('libelle_depense_id', $libelleDepense)
                    ->when($dateDebut && $dateFin, function ($query) use ($dateDebut, $dateFin) {
                        return $query->whereBetween('date_depense', [$dateDebut, $dateFin]);
                    })
                    ->when($dateDebut && !$dateFin, function ($query) use ($dateDebut) {
                        return $query->where('date_depense', '>=', $dateDebut);
                    })
                    ->when(!$dateDebut && $dateFin, function ($query) use ($dateFin) {
                        return $query->where('date_depense', '<=', $dateFin);
                    })
                    ->with(['categorie_depense', 'libelle_depense'])
                    ->get();
                // ->groupBy('libelle_depense_id')
                // ->map(function ($groupe) {
                //     return [
                //         'libelle' => $groupe->first()->libelle_depense->libelle,
                //         'montant_total' => $groupe->sum('montant'),
                //         'details' => $groupe
                //     ];
                // })
                // ->values();
                // dd($depenses->toArray());

                return view('backend.pages.rapport.detail_depense', compact('depenses', 'dateDebut', 'dateFin', 'categorieDepense'));
            }
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }



    /**
     * Affiche les ventes pour une periode donnee, un type de famille, une caisse, etc.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Exception
     */
    public function vente(Request $request)
    {
        try {
            $dateDebut = $request->input('date_debut');
            $dateFin = $request->input('date_fin');
            $caisseId = $request->input('caisse_id');
            $categorieFamille = $request->input('categorie_famille');
            $periode = $request->input('periode');
            // $categorieMenu = 'plat_menu';


            //Pour les vente bar et restaurant
            $query = Vente::with(['produits.categorie', 'plats.categorieMenu', 'caisse']);

            // pour la vente des plats menu
            $queryMenu = Vente::with(['plats.categorieMenu', 'caisse']);


            if ($dateDebut && $dateFin) {
                $query->whereBetween('date_vente', [$dateDebut, $dateFin]);
                $queryMenu->whereBetween('date_vente', [$dateDebut, $dateFin]);
            } elseif ($dateDebut) {
                $query->where('date_vente', '>=', $dateDebut);
                $queryMenu->where('date_vente', '>=', $dateDebut);
            } elseif ($dateFin) {
                $query->where('date_vente', '<=', $dateFin);
                $queryMenu->where('date_vente', '<=', $dateFin);
            }

            // if ($categorieFamille== 'plat_menu') {
            //     $queryMenu = Vente::with(['plats.categorieMenu', 'caisse']);
            // }elseif ($categorieFamille== 'bar' || $categorieFamille== 'menu') {
            //     $query = Vente::with(['plats.categorieMenu', 'caisse']);

            // }

            if ($caisseId) {
                $query->where('caisse_id', $caisseId);
                $queryMenu->where('caisse_id', $caisseId);
            }


            // Application du filtre de periode
            // periode=> jour, semaine, mois, année
            if ($request->filled('periode')) {
                if ($periode == 'jour') {
                    $query->whereDate('date_vente', Carbon::today());
                    $queryMenu->whereDate('date_vente', Carbon::today());
                } elseif ($periode == 'semaine') {
                    $query->whereBetween('date_vente', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
                    $queryMenu->whereBetween('date_vente', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
                } elseif ($periode == 'mois') {
                    $query->whereMonth('date_vente', Carbon::now()->month);
                    $queryMenu->whereMonth('date_vente', Carbon::now()->month);
                } elseif ($periode == 'annee') {
                    $query->whereYear('date_vente', Carbon::now()->year);
                    $queryMenu->whereYear('date_vente', Carbon::now()->year);
                }
            }

            // pour les vente bar et restaurant
            $ventes = $query->get();

            // pour la vente des plats menu
            $ventesMenu = $queryMenu->get();


            // pour les produits restaurant et bar
            $produitsVendus = $ventes->flatMap(function ($vente) {
                return $vente->produits;
            })->groupBy('id')->map(function ($groupe) use ($categorieFamille) {
                $produit = $groupe->first();
                if ($categorieFamille && $produit->categorie->famille !== $categorieFamille) {
                    return null;
                }
                return [
                    'id' => $produit->id,
                    'code' => $produit->code,
                    'stock' => $produit->stock,
                    'designation' => $produit->nom,
                    'categorie' => $produit->categorie->name,
                    'famille' => $produit->categorie->famille,
                    'quantite_vendue' => $groupe->sum('pivot.quantite'),
                    'prix_vente' => $groupe->first()->pivot->prix_unitaire,
                    'montant_total' => $groupe->sum(function ($item) {
                        return $item->pivot->quantite * $item->pivot->prix_unitaire;
                    }),
                ];
            })->filter()->values();

            //pour les plats menu
            $platsVendus = $ventesMenu->flatMap(function ($vente) {
                return $vente->plats;
            })->groupBy('id')->map(function ($groupe) {
                $plat = $groupe->first();
                // if ($categorieMenu && $plat->categorie->famille !== $categorieMenu) {
                //     return null;
                // }
                return [
                    'id' => $plat->id,
                    'code' => $plat->code,
                    'stock' => 100,
                    'designation' => $plat->nom,
                    'categorie' => $plat->categorieMenu->nom,
                    'famille' => 'Menu',
                    'quantite_vendue' => $groupe->sum('pivot.quantite'),
                    'prix_vente' => $groupe->first()->pivot->prix_unitaire,
                    'montant_total' => $groupe->sum(function ($item) {
                        return $item->pivot->quantite * $item->pivot->prix_unitaire;
                    }),
                ];
            })->filter()->values();
            $produitsVendus =  $produitsVendus->concat($platsVendus);

            // dd($produitsVendus->toArray());


            $caisses = Caisse::all();
            $famille = Categorie::whereNull('parent_id')->whereIn('type', ['bar', 'menu'])->orderBy('name', 'DESC')->get();


            return view('backend.pages.rapport.vente', compact('platsVendus', 'produitsVendus', 'caisses', 'dateDebut', 'dateFin', 'caisseId', 'categorieFamille', 'famille'));
        } catch (\Exception $e) {
            return back()->with('error', 'Une erreur s\'est produite : ' . $e->getMessage());
        }
    }

    function miseAJourStockVente()
    {
        // Récupération des ventes dont la catégorie famille est "bar"
        $data = DB::table('produit_vente')
            ->join('produits', 'produit_vente.produit_id', '=', 'produits.id')
            ->join('categories', 'produits.categorie_id', '=', 'categories.id')
            ->where('categories.famille', 'bar') // Filtrer uniquement les produits de la famille "bar"
            ->select('produit_vente.id', 'produit_vente.produit_id', 'produit_vente.variante_id', 'produit_vente.quantite') // Sélectionner les champs nécessaires
            ->get();

        foreach ($data as $value) {
            // Vérifier si produit_id, variante_id et quantite existent pour éviter une erreur
            if (!isset($value->produit_id, $value->variante_id, $value->quantite)) {
                continue; // Ignore cette ligne et passe à la suivante
            }

            // Récupération de la quantité de la variante
            $quantite = DB::table('produit_variante')
                ->where('produit_id', $value->produit_id)
                ->where('variante_id', $value->variante_id)
                ->value('quantite');

            // Vérification pour éviter une division par zéro
            if (is_null($quantite) || $quantite == 0) {
                continue;
            }

            // Mise à jour de la quantité de bouteilles vendues dans la table produit_vente uniquement pour les produits de la catégorie "bar"
            DB::table('produit_vente')
                ->join('produits', 'produit_vente.produit_id', '=', 'produits.id')
                ->join('categories', 'produits.categorie_id', '=', 'categories.id')
                ->where('categories.famille', 'bar') // Se limiter aux produits de la famille "bar"
                ->where('produit_vente.id', $value->id) // Condition sur l'ID du produit_vente
                ->update([
                    'quantite_bouteille' => round($value->quantite / $quantite, 2),
                ]);
        }
    }




    public function historique(Request $request)
    {
        try {

            // Appel de la fonction miseAJourStockVente()
            $this->miseAJourStockVente();

            $request->validate([
                'produit' => '',
                'dateDebut' => 'nullable',
                'dateFin' => 'nullable',
                'type' => '',
            ]);

            // recuperer les produit bar et restaurant
            $data_produit = Produit::active()->whereHas('categorie', function ($q) {
                $q->whereIn('famille', ['restaurant', 'bar']);
            })->get();

            // recuperer les request
            $produit = request('produit');
            $dateDebut = request('date_debut');
            $dateFin = request('date_fin');
            $type = request('type'); // vente, achat, inventaire , sortie

            $vente = [];
            $achat = [];
            $inventaire = [];
            $sortie = [];

            // vente
            if ($type == 'vente') {
                $vente = ProduitVente::with(['vente', 'variante', 'produit'])
                    ->where('produit_id', $produit)
                    ->orderBy('created_at', 'DESC');

                // Filtrer en fonction des dates
                if ($dateDebut && $dateFin) {
                    $vente->whereHas('vente', function ($query) use ($dateDebut, $dateFin) {
                        $query->whereBetween('date_vente', [$dateDebut, $dateFin]);
                    });
                } elseif ($dateDebut) {
                    $vente->whereHas('vente', function ($query) use ($dateDebut) {
                        $query->whereDate('date_vente', $dateDebut);
                    });
                } elseif ($dateFin) {
                    $vente->whereHas('vente', function ($query) use ($dateFin) {
                        $query->whereDate('date_vente', $dateFin);
                    });
                }

                // Récupération des données
                $vente = $vente->get();
            }


            // achat
            if ($type == 'achat') {
                $achat = Achat::with('produit')
                    ->where('produit_id', $produit)
                    ->orderBy('created_at', 'DESC');

                // Filtrer en fonction des dates
                if ($dateDebut && $dateFin) {
                    $achat->whereBetween('date_achat', [$dateDebut, $dateFin]);
                } elseif ($dateDebut) {
                    $achat->whereDate('date_achat', $dateDebut);
                } elseif ($dateFin) {
                    $achat->whereDate('date_achat', $dateFin);
                }

                // Récupération des données
                $achat = $achat->get();
            }


            // inventaire
            if ($type == 'inventaire') {
                $inventaire = InventaireProduit::with(['inventaire', 'produit'])
                    ->where('produit_id', $produit)
                    ->orderBy('created_at', 'DESC');

                // Filtrer en fonction des dates
                if ($dateDebut && $dateFin) {
                    $inventaire->whereHas('inventaire', function ($query) use ($dateDebut, $dateFin) {
                        $query->whereBetween('date_inventaire', [$dateDebut, $dateFin]);
                    });
                } elseif ($dateDebut) {
                    $inventaire->whereHas('inventaire', function ($query) use ($dateDebut) {
                        $query->whereDate('date_inventaire', $dateDebut);
                    });
                } elseif ($dateFin) {
                    $inventaire->whereHas('inventaire', function ($query) use ($dateFin) {
                        $query->whereDate('date_inventaire', $dateFin);
                    });
                }

                // Récupération des données
                $inventaire = $inventaire->get();
            }



            // inventaire
            if ($type == 'sortie') {
                $sortie = ProduitSortie::with(['sortie', 'produit'])
                    ->where('produit_id', $produit)
                    ->orderBy('created_at', 'DESC');

                // Filtrer en fonction des dates
                if ($dateDebut && $dateFin) {
                    $sortie->whereHas('sortie', function ($query) use ($dateDebut, $dateFin) {
                        $query->whereBetween('date_sortie', [$dateDebut, $dateFin]);
                    });
                } elseif ($dateDebut) {
                    $sortie->whereHas('sortie', function ($query) use ($dateDebut) {
                        $query->whereDate('date_sortie', $dateDebut);
                    });
                } elseif ($dateFin) {
                    $sortie->whereHas('sortie', function ($query) use ($dateFin) {
                        $query->whereDate('date_sortie', $dateFin);
                    });
                }

                // Récupération des données
                $sortie = $sortie->get();
            }


            // dd($sortie->toArray());


            return view('backend.pages.rapport.historique', compact('data_produit', 'vente', 'achat', 'inventaire', 'sortie'));
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Une erreur est survenue lors du chargement de l\'historique : ' . $e->getMessage()
            ], 500);
        }
    }
}
