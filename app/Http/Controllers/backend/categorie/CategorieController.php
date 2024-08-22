<?php

namespace App\Http\Controllers\backend\categorie;

use App\Models\Categorie;
use App\Models\TypeProduit;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;

class CategorieController extends Controller
{
    //

    public function create()
    {


        //create Categorie principal
        $data_categorie = Categorie::whereNull('parent_id')->with('children', fn ($q) => $q->OrderBy('position', 'ASC'))->withCount('children')->OrderBy('position', 'ASC')->get();

        //type produit
        // $data_type_produit = TypeProduit::all();
        // dd($data_categorie->toArray());
        return view('backend.pages.Categorie.create', compact('data_categorie'));
    }



    public function store(Request $request)
    {

        //request validation ......


        $data_count = Categorie::where('parent_id', null)->count();
        // dd($data_count);

        $data_categorie = Categorie::firstOrCreate([
            'name' => Str::lower($request['name']),
            'status' => $request['status'],
            'url' => $request['url'],
            'type_produit_id' => $request['type_produit'],
            'parent_id' => $request['type_produit'],

            'position' => $data_count + 1,
        ]);

        Alert::success('Operation réussi', 'Success Message');

        return back();
    }

    /**page view for add item */
    public function addSubCat(Request $request, $id)
    {
        //List Categorie
        $data_categorie = Categorie::whereNull('parent_id')->with('children', fn ($q) => $q->OrderBy('position', 'ASC'))->withCount('children')->OrderBy('position', 'ASC')->get();

        $data_categorie_parent = Categorie::find($id);


        return view('backend.pages.categorie.categorie-item',  compact('data_categorie', 'data_categorie_parent'));
    }


    public function addSubCatStore(Request $request)
    {
        //request validation ......

        $categorie_parent = Categorie::whereName($request['categorie_parent'])->first();
        //function for add position
        $data_count = Categorie::where('parent_id', $categorie_parent['id'])->count();

        $data_categorie = Categorie::firstOrCreate([
            'parent_id' => $categorie_parent['id'],
            'name' => Str::lower($request['name']),
            'status' => $request['status'],
            'url' => $request['url'],
            'position' => $data_count + 1,
        ]);

        Alert::success('Operation réussi', 'Success Message');

        return redirect()->route('categorie.create');
    }


    public function edit(Request $request, $id)
    {
        //List Categorie
        $data_categorie = Categorie::whereNull('parent_id')->with('children', fn ($q) => $q->OrderBy('position', 'ASC'))->withCount('children')->OrderBy('position', 'ASC')->get();

        $data_categorie_edit = Categorie::find($id);

        $data_count = Categorie::where('parent_id', $data_categorie_edit['parent_id'])->count();
        // dd($data_count);

        return view('backend.pages.categorie.categorie-edit',  compact('data_categorie', 'data_categorie_edit', 'data_count'));
    }


    public function update(Request $request, $id)
    {

        //request validation ......

        $data_categorie = Categorie::find($id)->update([
            'name' => Str::lower($request['name']),
            'status' => $request['status'],
            'url' => $request['url'],
            'position' => $request['position'],
        ]);

        Alert::success('Opération réussi', 'Success Message');
        return redirect()->route('categorie.create');
    }


    public function delete($id)
    {
        //
        $data_categorie_edit = Categorie::find($id);
        $data_categorie = Categorie::where('parent_id', $data_categorie_edit['parent_id'])->get();
        foreach ($data_categorie as $key => $value) {
            Categorie::whereId($value['id'])->update([
                'position' => $key + 1
            ]);
        }
        //
        Categorie::find($id)->delete();

        // Alert::success('Opération réussi', 'Success Message');
        // return redirect()->route('categorie.create');

        return response()->json([
            'status' => 200,
        ]);
    }
}
