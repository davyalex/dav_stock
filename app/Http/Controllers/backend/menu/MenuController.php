<?php

namespace App\Http\Controllers\backend\menu;

use App\Models\Categorie;
use App\Models\ProduitMenu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class MenuController extends Controller
{
    //
    public function index() {}

    public function create(Request $request)
    {
        try {

            $data_categorie = Categorie::whereNull('parent_id')->with('children', fn($q) => $q->OrderBy('position', 'ASC'))->withCount('children')
                ->whereIn('name', ['menu'])
                ->OrderBy('position', 'ASC')->get();

            // $data_produit_menu = ProduitMenu::select('categorie_id', DB::raw('count(*) as total_products'))
            //     ->with('categorie')
            //     ->groupBy('categorie_id')
            //     ->get();
            $data_categorie_produit = Categorie::withWhereHas('produit_menus')->get();


            // dd($data_categorie->toArray());

            return view('backend.pages.menu.create', compact('data_categorie', 'data_categorie_produit'));
        } catch (\Throwable $e) {
            return $e->getMessage();
        }
    }
}
