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
            // $menu = Menu::where('date_menu', $today)->with(['produits.categorie', 'produits.achats'])->first();

            // Supposez que vous avez une colonne "est_menu_du_jour" pour identifier le menu du jour
            $menu = Menu::with(['produits.achats', 'produits.categorie' => function ($query) {
                $query->with(['parent', 'children']); // On récupère le parent pour chaque catégorie
            }])->first();

            // Filtrer les produits par catégorie principale
            $produitsFiltres = $menu->produits->groupBy(function ($produit) {
                return $produit->categorie->getPrincipalCategory()->type;
            });

            // Récupérer toutes les catégories associées au menu du jour
            $categories = $this->getCategoriesRecursivesFromMenu($menu);




            dd($categories->toArray());
            return view('site.pages.menu', compact('menu', 'categories', 'produitsFiltres'));
        } catch (\Throwable $e) {
            return $e->getMessage();
        }
    }



    // Récupérer toutes les catégories du menu du jour
    // private function getCategoriesFromMenu($menu)
    // {
    //     $categories = collect();

    //     foreach ($menu->produits as $produit) {
    //         $categorie = $produit->categorie->getPrincipalCategory();
    //         $categories->push($categorie);
    //     }

    //     // Éviter les doublons en utilisant `unique` sur l'identifiant de la catégorie
    //     return $categories->unique('id');
    // }


    // Récupérer toutes les catégories principales et leurs enfants associés au menu du jour
    private function getCategoriesRecursivesFromMenu($menu)
    {
        $categories = collect();

        foreach ($menu->produits as $produit) {
            $categorie = $produit->categorie->getPrincipalCategory();
            $categories->push($categorie);

            // Ajouter les enfants de chaque catégorie principale
            $categories = $categories->merge($this->getEnfantsRecursifs($categorie));
        }

        // Éviter les doublons dans la liste des catégories
        return $categories->unique('id');
    }

    // Récupérer les enfants des catégories récursivement
    private function getEnfantsRecursifs($categorie)
    {
        $categories = collect();

        // Vérification que 'children' est bien un objet itérable
        if ($categorie->children && $categorie->children->isNotEmpty()) {
            foreach ($categorie->children as $enfant) {
                $categories->push($enfant);

                // Appel récursif pour récupérer les enfants des enfants
                $categories = $categories->merge($this->getEnfantsRecursifs($enfant));
            }
        }

        return $categories;
    }



    // public function
}
