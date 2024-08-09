<?php

namespace App\Http\Controllers\backend\stock;

use App\Models\Unite;
use App\Models\Format;
use App\Models\Produit;
use App\Models\Categorie;
use App\Models\Fournisseur;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StockController extends Controller
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
            return view('backend.pages.stock.entree.create', compact('type_produit', 'data_categorie', 'data_produit', 'data_format', 'data_unite', 'data_fournisseur'));
        } catch (\Throwable $e) {
            return  $e->getMessage();
        }

        // dd($data_categorie->toArray());

    }


    public function store(Request $request)
    {
        try {
            $type_produit = Categorie::where('type_id', $request['type_produit'])->first();
            //if request == restaurant
            if ($type_produit['name'] == 'restaurant') {
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
            }
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }
}
