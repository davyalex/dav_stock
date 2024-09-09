<?php

namespace App\Http\Controllers\site;

use Carbon\Carbon;
use App\Models\Menu;
use App\Models\Slide;
use App\Models\Produit;
use App\Models\Categorie;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SiteController extends Controller
{
    /**Accueil du site */

    public function accueil()
    {
        try {
            //slider
            $data_slide = Slide::with('media')->orderBy('id', 'DESC')->get();

            return view('site.pages.accueil', compact(
                'data_slide',
            ));
        } catch (\Throwable $e) {
            return $e->getMessage();
        }
    }



    /**Liste des produit en fonction de la categorie
     * 
     * @param{slug-categorie}
     */
    public function produit(Request $request, $slug)
    {
        try {
            $categorieSelect = Categorie::whereSlug($slug)->first(); // recuperer les infos de la categorie a partir du slug

            if (!$categorieSelect) {
                return redirect()->route('accueil');
            }
            // retourner les achats du produits si type=boissons
            if ($categorieSelect->type == 'boissons') {
                $produits = Produit::where('type_id', $categorieSelect->id)
                    ->withWhereHas('achats', fn($q) => $q->whereStatut('active'))
                    ->whereStatut('active')
                    ->get();  // produits de la categorie selectionné si type ==boissons

            } elseif ($categorieSelect->type == 'plats') {
                $produits = Produit::where('type_id', $categorieSelect->id)
                    ->whereStatut('active')
                    ->get();
            } else {
                $produits = Produit::where('categorie_id', $categorieSelect->id)
                    ->whereStatut('active')
                    ->get();
            }

            // dd($produits->toArray());
            // $produits  =   $produits->achats;

            // $categorie = Categorie::with(['children' , 'parent'])
            //     ->withCount('children')->where('parent_id', $categorieSelect->id)->OrderBy('position', 'ASC')->get();  // categorie et ses souscategorie 

            $categories = Categorie::whereNull('parent_id')
                ->with('children')
                ->whereIn('type', ['plats', 'boissons'])
                ->orderBy('position', 'ASC')
                ->get();
            // dd($categorie->toArray());

            return view('site.pages.produit', compact(
                'produits',
                'categories',
                'categorieSelect',
            ));
        } catch (\Throwable $e) {
            return $e->getMessage();
        }
    }


    public function menu(Request $request)
    {
        try {
            $today = Carbon::today();

            // Récupérer le menu du jour avec les relations nécessaires
            $menu = Menu::with([
                'produits.achats',
                'produits.categorie' => function ($query) {
                    $query->with(['parent', 'children', 'descendants']); // Charger les sous-catégories
                }
            ])->where('date_menu', $today)->first();

            if ($menu) {
                // Récupérer toutes les catégories associées aux produits du menu
                $categories = $this->getCategoriesFromMenu($today);

                // Si une catégorie est passée dans la requête
                if ($request->has('categorie')) {
                    $categorieRequest = Categorie::where('slug', $request->categorie)->first();

                    if ($categorieRequest) {
                        // Filtrer les produits appartenant à la catégorie demandée ou ses descendants
                        $produitsFiltres = $menu->produits->filter(function ($produit) use ($categorieRequest) {
                            return $produit->categorie->id === $categorieRequest->id ||
                                $produit->categorie->parent_id === $categorieRequest->id ||
                                $produit->categorie->descendants->contains('id', $categorieRequest->id);
                        });

                        // Regrouper les produits filtrés par la catégorie principale
                        $produitsFiltres = $produitsFiltres->groupBy(function ($produit) {
                            return $produit->categorie->getPrincipalCategory()->type;
                        });

                        return view('site.pages.menu', compact('menu', 'produitsFiltres', 'categories', 'categorieRequest'));
                    }
                } else {
                    // Si aucune catégorie spécifique n'est demandée, on regroupe par catégorie principale
                    $produitsFiltres = $menu->produits->groupBy(function ($produit) {
                        return $produit->categorie->getPrincipalCategory()->type;
                    });

                    return view('site.pages.menu', compact('menu', 'produitsFiltres', 'categories'));
                }
            } else {
                // Si aucun menu n'est trouvé pour aujourd'hui
                $produitsFiltres = collect();
                $categories = [];
                

                return view('site.pages.menu', compact('menu', 'produitsFiltres', 'categories'));
            }
        } catch (\Throwable $e) {
            return $e->getMessage();
        }
    }



    public function produitDetail($slug) {

        try {
            $produit = Produit::where('slug', $slug)->first();
            $produit = Produit::find($produit->id);
            // dd($produit->categorie->toArray());
            
           return view('site.pages.produit-detail' , compact('produit'));
        } catch (\Throwable $e) {
            return $e->getMessage();
        }
    }



    // Controller

    public function getCategoriesFromMenu($today)
    {
        // Charger le menu avec les produits et les catégories
        $menu = Menu::with([
            'produits.categorie' => function ($query) {
                $query->with(['parent', 'children' => function ($q) {
                    $q->with('children'); // Charger les sous-catégories récursivement
                }]);
            }
        ])->where('date_menu', $today)->first();

        if (!$menu) {
            return collect(); // Retourner une collection vide si le menu n'existe pas
        }

        // Récupérer toutes les catégories des produits du menu
        $categories = collect();
        foreach ($menu->produits as $produit) {
            $categorie = $produit->categorie;
            if ($categorie) {
                $categories = $categories->merge($categorie->descendants->push($categorie));
            }
        }

        // Grouper les catégories par leur catégorie principale
        $groupedCategories = $categories->groupBy(function ($categorie) {
            return $categorie->getPrincipalCategory()->id; // Grouper par catégorie principale
        })->map(function ($categorieGroup) {
            return $categorieGroup->unique('id');
        });

        return $groupedCategories;
    }











    // public function
}
