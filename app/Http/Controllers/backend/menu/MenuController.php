<?php

namespace App\Http\Controllers\backend\menu;

use App\Models\Categorie;
use App\Models\ProduitMenu;
use Illuminate\Http\Request;
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

                $data_produit_menu = ProduitMenu::all();


            // dd($data_produit_menu->toArray());

            return view('backend.pages.menu.create', compact('data_categorie' , 'data_produit_menu'));
        } catch (\Throwable $e) {
            return $e->getMessage();
        }
    }
}
