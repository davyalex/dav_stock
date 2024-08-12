<?php

namespace App\Http\Controllers\backend\stock;

use App\Models\Unite;
use App\Models\Entree;
use App\Models\Format;
use App\Models\Produit;
use App\Models\Categorie;
use App\Models\Fournisseur;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EntreeController extends Controller
{
    //

    public function index() {}

    public function create(Request $request)
    {

        try {
            $data_categorie = Categorie::whereNull('parent_id')->with('children', fn($q) => $q->OrderBy('position', 'ASC'))->withCount('children')->OrderBy('position', 'ASC')->get();
            $data_produit = Produit::with(['categorie.ancestors', 'media'])->get();
            $type_produit = Categorie::whereNull('parent_id')->whereIn('name', ['bar', 'restaurant'])->get();

            $data_format = Format::all();
            $data_unite = Unite::all();
            $data_fournisseur = Fournisseur::all();

            // dd($data_produit->toArray());
            return view('backend.pages.produit.create', compact('type_produit', 'data_categorie', 'data_produit', 'data_format', 'data_unite', 'data_fournisseur'));
        } catch (\Throwable $e) {
            return  $e->getMessage();
        }

        // dd($data_categorie->toArray());

    }


    public function store(Request $request)
    {
        try {
            //recuperer le type de entree : bar ?restaurant            
            $type_entree = $request['type_entree'];
            $type_entree = Categorie::whereId($type_entree)->first();
            if ($type_entree->name == 'restaurant') {
                $request->validate([
                    'produit' => 'required',
                    'quantite_format' => 'required',
                    'format' => 'required',
                    'unite' => 'required',
                    'valeur_unite' => 'required', // valeur par unite
                    'quantite_stockable' => 'required', // --qte stockable
                    'fournisseur' => 'required',
                    'prix_achat_unitaire' => 'required',
                    'prix_achat_total' => 'required',
                    'statut' => '',


                ]);



                $stock_entree = Entree::create([
                    'type_entree_id' => $type_entree->id,
                    'type_entree_id' => $type_entree->id,
                    'produit_id' => $request['produit_id'],
                    'format_id' => $request['format_id'],
                    'unite_id' => $request['unite_id'],
                    'fournisseur_id' => $request['fournisseur_id'],
                    'quantite_format' => $request['quantite_format'],
                    'quantite_unité_unitaire' => $request['quantite_unité_unitaire'],
                    'quantite_unité_total' => $request['quantite_unité_total'],


                ]);
            }
        } catch (\Throwable $e) {
            return $e->getMessage();
        }
    }
}
