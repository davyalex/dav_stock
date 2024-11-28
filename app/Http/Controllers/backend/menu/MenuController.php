<?php

namespace App\Http\Controllers\backend\menu;

use App\Models\Menu;
use App\Models\Plat;
use App\Models\Produit;
use App\Models\Categorie;
use App\Models\ProduitMenu;
use Illuminate\Http\Request;
use App\Models\CategorieMenu;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

use function Deployer\desc;

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
            //toutes les categorie menu sauf  complement et garniture
            $categorie_complement_garniture = CategorieMenu::orderBy('position', 'ASC')
                ->whereIn('slug', ['complements', 'garnitures'])
                ->get();


            // toutes les categorie menu  sauf complement et garniture
            $categorie_menu = CategorieMenu::active()->with('plats')
                ->whereNotIn('slug', ['complements', 'garnitures'])
                ->orderBy('position', 'ASC')->get();

            //uniquement categorie menu complements
            $categorie_complements = CategorieMenu::with('plats')->where('slug', 'complements')->first();

            // recuperer les plats
            $plats = Plat::active()->whereDoesntHave('categorieMenu', function ($query) {
                $query->whereIn('slug', ['complements', 'garnitures']);
            })->get();

            //recuperer les plats complement
            $plats_complements = Plat::active()->whereHas('categorieMenu', function ($query) {
                $query->where('slug', 'complements');
            })->get();


            //recuperer les plats garnitures
            $plats_garnitures = Plat::active()->whereHas('categorieMenu', function ($query) {
                $query->where('slug', 'garnitures');
            })->get();
            // dd($plats_complements->toArray());

            return view('backend.pages.menu.create', compact('categorie_complement_garniture', 'categorie_complements', 'categorie_menu', 'plats', 'plats_complements', 'plats_garnitures'));
        } catch (\Throwable $e) {
            return $e->getMessage();
        }
    }


    public function getOptions()
    {
        // Récupérer les données
        $plats = Plat::active()->whereDoesntHave('categorieMenu', function ($query) {
            $query->whereIn('slug', ['complements', 'garnitures']);
        })->orderBy('created_at', 'desc')->get();
        $platsComplements = Plat::active()->whereHas('categorieMenu', function ($query) {
            $query->where('slug', 'complements');
        })->orderBy('created_at', 'desc')->get();
        $platsGarnitures = Plat::active()->whereHas('categorieMenu', function ($query) {
            $query->where('slug', 'garnitures');
        })->orderBy('created_at', 'desc')->get();

        // Retourner les données en JSON
        return response()->json([
            'plats' => $plats,
            'plats_complements' => $platsComplements,
            'plats_garnitures' => $platsGarnitures,
        ]);
    }



    public function store(Request $request)
    {
        try {
            // dd($request->toArray());
            // Valider les données
            $validatedData = $request->validate([
                'date_menu' => 'required|unique:menus',
                'plats' => 'required|array',
                'plats.*.categorie_id' => 'required|exists:categorie_menus,id',
                'plats.*.plat_selected' => 'required|exists:plats,id',
                'plats.*.complements' => 'nullable|array',
                'plats.*.complements.*' => 'exists:plats,id',
                'plats.*.garnitures' => 'nullable|array',
                'plats.*.garnitures.*' => 'exists:plats,id',
            ], [
                'date_menu.required' => 'La date du menu est requise.',
                'date_menu.unique' => 'Un menu a déjà été créé pour cette date, Vous pouvez la modifier.',
            ]);

            // Créer ou récupérer le menu
            $libelle = $request['libelle'] ? $request['libelle'] : 'Menu du ' . $request->date_menu;
            $menu = Menu::firstOrCreate([
                'date_menu' => $request->date_menu,
                'libelle' => $libelle,
                'user_id' => Auth::id(),
            ]);

            // Parcourir les plats
            foreach ($validatedData['plats'] as $platData) {
                $plat = Plat::find($platData['plat_selected']);

                // Ajouter le plat au menu
                $menu->plats()->attach($plat->id, ['categorie_menu_id' => $plat->categorie_menu_id]);

                // Ajouter les compléments
                if (!empty($platData['complements'])) {
                    foreach ($platData['complements'] as $complementId) {
                        $plat->complements()->attach($complementId, ['menu_id' => $menu->id]);
                    }
                }

                // Ajouter les garnitures
                if (!empty($platData['garnitures'])) {
                    foreach ($platData['garnitures'] as $garnitureId) {
                        $plat->garnitures()->attach($garnitureId, ['menu_id' => $menu->id]);
                    }
                }
            }

            // enregistrer image
            if ($request->hasFile('image')) {
                $menu->addMediaFromRequest('image')->toMediaCollection('images');
            }


            Alert::success('Operation réussi', 'Success Message');
            return back();
        } catch (\Throwable $e) {
            return $e->getMessage();
            // Alert::error($e->getMessage(),  'Une erreur s\'est produite');
            // return back();
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
