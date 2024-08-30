<?php

namespace App\Http\Controllers\site;

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
            $getCategorie = Categorie::whereSlug($slug)->first(); // recuperer les infos de la categorie a partir du slug

            if (!$getCategorie) {
                return redirect()->route('accueil');
            }
            // retourner les achats du produits si type=boissons
            if ($getCategorie->type == 'boissons') {
                $produits = Produit::where('type_id', $getCategorie->id)
                    ->withWhereHas('achats', fn($q) => $q->whereStatut('active'))
                    ->whereStatut('active')
                    ->get();  // produits de la categorie selectionné si type ==boissons

            } elseif ($getCategorie->type != 'boissons') {
                $produits = Produit::where('type_id', $getCategorie->id)
                    ->whereStatut('active')
                    ->get();
            }


            // $produits  =   $produits->achats;

            $categorie = Categorie::with('children')
                ->withCount('children')->whereId($getCategorie->id)->OrderBy('position', 'ASC')->first();  // categorie et ses souscategorie 

            // dd($produits->toArray());


            return view('site.pages.produit', compact(
                'produits',
                'categorie',
            ));
        } catch (\Throwable $e) {
            return $e->getMessage();
        }
    }
}
