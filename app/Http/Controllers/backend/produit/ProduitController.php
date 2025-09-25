<?php

namespace App\Http\Controllers\backend\produit;

use App\Models\Unite;
use App\Models\Format;
use App\Models\Magasin;
use App\Models\Produit;
use App\Models\Variante;
use App\Models\Categorie;
use App\Models\Fournisseur;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;

class ProduitController extends Controller
{







    //
    public function index(Request $request)
    {

        $data_produit = Produit::with('categorie')->OrderBy('created_at', 'DESC')->get();

        return view('backend.pages.produit.index', compact('data_produit'));
    }

    public function create(Request $request)
    {
        try {
            $data_categorie = Categorie::whereNull('parent_id') // Catégories principales
                ->with('children', fn($q) => $q->orderBy('position', 'ASC')) // Récupérer les sous-catégories avec tri
                ->withCount('children') // Compter le nombre d'enfants pour chaque catégorie
                ->orderBy('position', 'ASC') // Trier les catégories principales par position
                ->get();

            // Récupérer toutes les catégories (avec leurs enfants, s'ils existent)
            $categorieAll = Categorie::with('children')->get();

            return view('backend.pages.produit.create', compact('data_categorie', 'categorieAll',));
        } catch (\Throwable $e) {
            return $e->getMessage();
        }
    }




    public function store(Request $request)
    {
        try {
            // Récupérer la catégorie sélectionnée
            $categorie = Categorie::find($request['categorie_id']);
            $principaCat = $categorie ? $categorie->getPrincipalCategory() : null;

            // Validation des données
            $data = $request->validate([
                'nom' => 'required|string|max:255',
                'description' => 'nullable|string',
                'categorie_id' => 'required|exists:categories,id',
                'stock_alerte' => 'required|integer|min:0',
                'prix' => 'required|numeric|min:0',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            ]);

            // Vérifier si le produit existe déjà
            $existingProduct = Produit::where('nom', $request['nom'])
                ->where('categorie_id', $request['categorie_id'])
                ->exists();

            if ($existingProduct) {
                return back()->with('error', 'Le produit existe déjà.');
            }

            // Générer un SKU unique
            $sku = 'PROD-' . strtoupper(Str::random(8));

            // Créer le produit
            $data_produit = Produit::create([
                'nom' => $request['nom'],
                'code' => $sku,
                'description' => $request['description'],
                'categorie_id' => $request['categorie_id'],
                'stock_alerte' => $request['stock_alerte'],
                'type_id' => $principaCat ? $principaCat['id'] : null,
                'prix' => $request['prix'],
                'statut' => 'active',
                'user_id' => Auth::id(),
            ]);

            // Gestion de l'image principale
            if ($request->hasFile('image')) {
                $media = $data_produit->addMediaFromRequest('image')->toMediaCollection('ProduitImage');
                \Spatie\ImageOptimizer\OptimizerChainFactory::create()->optimize($media->getPath());
            }

            Alert::success('Opération réussie', 'Produit créé avec succès');
            return redirect()->route('produit.create');
        } catch (\Throwable $e) {
            return back()->with('error', 'Une erreur s\'est produite : ' . $e->getMessage());
        }
    }


    public function show($id)
    {
        try {
            $data_produit = Produit::find($id);
            return view('backend.pages.produit.show', compact('data_produit'));
        } catch (\Throwable $e) {
            return $e->getMessage();
        }
    }


    public function edit($id)
    {
        try {

           
            $data_produit = Produit::find($id);
            // dd($data_produit->variantes->toArray());


            $data_categorie = Categorie::whereNull('parent_id')->with('children', fn($q) => $q->OrderBy('position', 'ASC'))->withCount('children')
                ->OrderBy('position', 'ASC')->get();


            // children ctegories of famile select
            $data_categorie_edit = Categorie::where('parent_id', $data_produit->type_id)->with('children', fn($q) => $q->OrderBy('position', 'ASC'))->withCount('children')
                ->OrderBy('position', 'ASC')->get();


            $categorieAll = Categorie::all();
            return view('backend.pages.produit.edit', compact('data_produit', 'data_categorie', 'data_categorie_edit', 'categorieAll'));
        } catch (\Throwable $e) {
            return $e->getMessage();
        }
    }




    public function update(Request $request, $id)
    {
        try {
            // Récupérer la catégorie principale
            $categorie = Categorie::find($request['categorie_id']);
            $principaCat = $categorie ? $categorie->getPrincipalCategory() : null;

            // Validation des données
            $request->validate([
                'nom' => 'required|string|max:255',
                'description' => 'nullable|string',
                'categorie_id' => 'required|exists:categories,id',
                'stock_alerte' => 'required|integer|min:0',
                'prix' => 'required|numeric|min:0',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            ]);

        

            // Mise à jour du produit
            $data_produit = Produit::find($id);
            $data_produit->update([
                'nom' => $request['nom'],
                'description' => $request['description'],
                'categorie_id' => $request['categorie_id'],
                'stock_alerte' => $request['stock_alerte'],
                'type_id' => $principaCat ? $principaCat['id'] : null,
                'prix' => $request['prix'],
                'statut' => $request['statut'],
                'user_id' => Auth::id(),
            ]);

            // Mise à jour de l'image principale
            if ($request->hasFile('image')) {
                $data_produit->clearMediaCollection('ProduitImage');
                $media = $data_produit->addMediaFromRequest('image')->toMediaCollection('ProduitImage');
                \Spatie\ImageOptimizer\OptimizerChainFactory::create()->optimize($media->getPath());
            }

            Alert::success('Opération réussie', 'Produit modifié avec succès');
            return redirect()->route('produit.edit', $id);
        } catch (\Throwable $e) {
            return back()->with('error', 'Une erreur s\'est produite : ' . $e->getMessage());
        }
    }


    public function delete($id)
    {
        Produit::find($id)->forceDelete();
        return response()->json([
            'status' => 200,
        ]);
    }
}
