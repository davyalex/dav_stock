<?php

namespace App\Http\Controllers\backend\menu;

use App\Models\Menu;
use App\Models\Produit;
use App\Models\Categorie;
use App\Models\ProduitMenu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class MenuController extends Controller
{
    //
    public function index()
    {
        try {
            $data_menu = Menu::all();
            return view('backend.pages.menu.index',  compact('data_menu'));
        } catch (\Throwable $e) {
            return $e->getMessage();
        }
    }

    public function create(Request $request)
    {
        try {

            $data_categorie_menu = Categorie::with(['children', 'produits'])
                ->whereNotNull('parent_id')
                ->whereIn('famille', ['menu'])
                ->whereNotIn('slug', ['complements'])
                ->orderBy('position', 'ASC')
                ->get();

            $categorie_complements = Categorie::with('produits')->where('slug', 'complements')->first();

            // dd($categorie_complements->toArray());

            return view('backend.pages.menu.create', compact('data_categorie_menu', 'categorie_complements'));
        } catch (\Throwable $e) {
            return $e->getMessage();
        }
    }


    public function store(Request $request)
    {
        try {


            // dd($request->toArray());

            // Valider les données


            $validatedData = $request->validate([
                'date_menu' => 'required|unique:menus',
                'produits' => 'required|array',
                'produits.*.selected' => 'boolean',
                'produits.*.complements' => 'nullable|array',
            ], [
                'date_menu.required' => 'La date du menu est requise.',
                'date_menu.unique' => 'Un menu a déjà été crée pour cette date men, Vous pouvez la modifier.',
            ]);




            // $dateExistante = Menu::where('date_menu', $request->date_menu)->exists();
            // if ($dateExistante) {
            //     Alert::error('Une erreur s\'est produite', 'Une date de menu existe déjà pour cette date.');
            //     return back();
            // }



            $libelle = $request['libelle'] ? $request['libelle'] : 'Menu du ' . $request->date_menu;

            $menu = Menu::firstOrCreate([
                'date_menu' => $request->date_menu,
                'libelle' => $libelle,
                'user_id' => Auth::id(),
            ]);

            //method attach product with menu 
            // $menu->produits()->sync($validatedData['produits']);

            // Parcourir les produits et enregistrer leur composition
            // foreach ($validatedData['produits'] as $produitId => $produitData) {
            //     if (isset($produitData['selected']) && $produitData['selected']) {
            //         // Ajouter le produit au menu
            //         $menu->produits()->attach($produitId);

            //         // Si des compléments sont sélectionnés, les enregistrer
            //         if (!empty($produitData['complements'])) {
            //             $produit = Produit::find($produitId);
            //             $produit->complements()->syncWithoutDetaching($produitData['complements'], ['menu_id' => $menu->id]);
            //         }
            //     }
            // }


            foreach ($validatedData['produits'] as $produitId => $produitData) {
                if (isset($produitData['selected']) && $produitData['selected']) {
                    // Ajouter le produit au menu
                    $menu->produits()->sync($produitId);

                    // Si des compléments sont sélectionnés, les enregistrer
                    if (!empty($produitData['complements'])) {
                        $complements = [];
                        foreach ($produitData['complements'] as $complementId) {
                            $complements[$complementId] = ['menu_id' => $menu->id];
                        }

                        // Ajouter les compléments avec les données supplémentaires
                        $produit = Produit::find($produitId);
                        $produit->complements()->sync($complements);
                    }
                }
            }


            Alert::success('Operation réussi', 'Success Message');
            return back();
        } catch (\Throwable $e) {
            // return $e->getMessage();
            Alert::error($e->getMessage(),  'Une erreur s\'est produite');
            return back();
        }
    }

    public function edit($id)
    {
        try {
            // $data_categorie_menu = Categorie::with('children')
            //     ->whereNull('parent_id')
            //     ->whereIn('famille', ['menu', 'bar'])
            //     ->get();

            $data_categorie_menu = Categorie::with(['children', 'produits'])
                ->whereNotNull('parent_id')
                ->whereIn('famille', ['menu'])
                ->whereNotIn('slug', ['complements'])
                ->orderBy('position', 'ASC')
                ->get();

            $categorie_complements = Categorie::with('produits')->where('slug', 'complements')->first();

            $data_menu = Menu::findOrFail($id);
            if (!$data_menu) {
                return redirect()->route('menu.index');
            }

            //    dd($data_produit->produit_menu->toArray());

            return view('backend.pages.menu.edit', compact('data_categorie_menu', 'data_menu', 'categorie_complements'));
        } catch (\Throwable $e) {
            Alert::error($e->getMessage(),  'Une erreur s\'est produite');
            return back();
        }
    }


    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'date_menu' => 'required',
                // required produit min:1
                'produits' => 'required|array|min:1',
            ]);

            $libelle = $request['libelle'] ? $request['libelle'] : 'Menu du ' . $request->date_menu;
            $data_menu = Menu::find($id);
            $data_menu->update([
                'date_menu' => $request->date_menu,
                'libelle' => $libelle,
                'user_id' => Auth::id(),
            ]);
            //method attach product with menu
            $data_menu->produits()->sync($request['produits']);
            Alert::success('Operation réussi', 'Success Message');
            return back();
        } catch (\Throwable $e) {
            Alert::error($e->getMessage(),  'Une erreur s\'est produite');
            return back();
        }
    }





    public function delete($id)
    {
        try {
            DB::table('menu_produit')->where('menu_id', $id)->delete();

            Menu::find($id)->forceDelete();
            return response()->json([
                'status' => 200,
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'status' => 500,
                'message' => $e->getMessage(),
            ]);
        }
    }
}
