<?php

namespace App\Http\Controllers\backend\menu;

use App\Models\Menu;
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

            $data_categorie_produit = Categorie::withWhereHas('produit_menus')->get();

            return view('backend.pages.menu.create', compact('data_categorie_produit'));
        } catch (\Throwable $e) {
            return $e->getMessage();
        }
    }


    public function store(Request $request)
    {
        try {
            $request->validate([
                'date_menu' => 'required|unique:menus',
            ]);

            $libelle = $request['libelle'] ? $request['libelle'] : 'Menu du ' . $request->date_menu;


            $data_menu = Menu::firstOrCreate([
                'date_menu' => $request->date_menu,
                'libelle' => $libelle,
                'user_id' => Auth::id(),
            ]);

            //method attach product with menu 
            $data_menu->produit_menu()->sync($request['produits']);

            Alert::success('Operation réussi', 'Success Message');
            return back();
        } catch (\Throwable $e) {
            // return $e->getMessage();
            if ($e->getMessage() == 'The date menu has already been taken.') {
                Alert::error('Un menu est déjà crée pour cette date', 'Une erreur s\'est produite');
                return back();
            } else {
                Alert::error($e->getMessage(),  'Une erreur s\'est produite');
                return back();
            }
        }
    }

    public function edit($id)
    {
        try {
            // $data_menu = Menu::with('produit_menu')->find($id);
            $data_categorie_produit = Categorie::withWhereHas('produit_menus')->get();
            $data_menu = Menu::find($id);

        //    dd($data_produit->produit_menu->toArray());

            return view('backend.pages.menu.edit', compact('data_categorie_produit' , 'data_menu'));
        } catch (\Throwable $e) {
            Alert::error($e->getMessage(),  'Une erreur s\'est produite');
            return back();
        }
    }






    public function delete($id)
    {
        try {
            DB::table('menu_produit_menu')->where('menu_id', $id)->delete();

            Menu::find($id)->delete();
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
