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
            $menu = Menu::where('date_menu', $today)->with(['produits.categorie', 'produits.achats'])->first();

            $catData=[];
            $cat = $menu->produits->pluck('categorie');
            foreach ($cat as  $value) {
                array_push( $catData , $value->getPrincipalCategory());
            }

            // $categorie = Categorie::withWhereHas('children.produits')
            // ->whereIn('type', ['plats', 'boissons'])->get();

            // $categories = Categorie::whereNull('parent_id')
            //     ->with('children.produits')
            //     ->whereIn('type', ['plats', 'boissons'])
            //     ->orderBy('position', 'ASC')
            //     ->get();

            
            dd($catData);
            return view('site.pages.menu', compact('menu' , 'categories'));
        } catch (\Throwable $e) {
            return $e->getMessage();
        }
    }


    // public function
}
