<?php

namespace App\Http\Controllers\backend\menu;

use Illuminate\Http\Request;
use App\Models\CategorieMenu;
use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;

class CategorieMenuController extends Controller
{
    //
    public function index()
    {

        $data_CategorieMenu = CategorieMenu::get();
        $data_CategorieMenu->sortBy('name');


        return view('backend.pages.menu.categorie.index', compact('data_CategorieMenu'));
    }


    public function store(Request $request)
    {
        //request validation .......
        $data =  $request->validate([
            'nom' => 'required',
            'statut' => 'required'
        ]);
        CategorieMenu::firstOrCreate($data);

        Alert::success('Operation réussi', 'Success Message');

        return back();
    }


    public function update(Request $request, $id)
    {

        //request validation ......
        //request validation .......
        $data =  $request->validate([
            'nom' => 'required',
            'statut' => 'required'
        ]);

        $categorie = CategorieMenu::find($id)->update([
            'name' => $request['name'],
            'statut' => $request['statut']
        ]);

        Alert::success('Opération réussi', 'Success Message');
        return back();
    }


    public function delete($id)
    {
        CategorieMenu::find($id)->delete();
        return response()->json([
            'status' => 200,
        ]);
    }
}
