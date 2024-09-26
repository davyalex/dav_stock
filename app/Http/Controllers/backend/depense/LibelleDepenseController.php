<?php

namespace App\Http\Controllers\backend\depense;

use Illuminate\Http\Request;
use App\Models\LibelleDepense;
use App\Models\CategorieDepense;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class LibelleDepenseController extends Controller
{
    public function index()
    {
        //
        try {
            $data_libelleDepense = LibelleDepense::OrderBy('libelle', 'ASC')->get();
            $categorie_depense = CategorieDepense::OrderBy('libelle', 'ASC')->get();
            return view('backend.pages.depense.libelle-depense.index', compact('data_libelleDepense' , 'categorie_depense'));
        } catch (\Throwable $th) {
            //throw $th;
            return $th->getMessage();
        }
    }


    public function store(Request $request)
    {
        try {

            $data = $request->validate([
                'libelle' => 'required',
                'categorie_depense_id' => 'required',
                'description' => '',

            ]);

            $data_count = LibelleDepense::count();

            $data_LibelleDepense = LibelleDepense::firstOrCreate($data, ['user_id' => Auth::id()]);

            Alert::success('Operation réussi', 'Success Message');
            return back();
        } catch (\Throwable $e) {
            return $e->getMessage();
        }
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {

        try {
            //request validation ......
            $data = $request->validate([
                'libelle' => 'required',
                'categorie_depense_id' => 'required',
                'description' => '',

            ]);


            $data_LibelleDepense = LibelleDepense::find($id)->update($data, ['user_id' => Auth::id()]);

            Alert::success('Opération réussi', 'Success Message');
            return back();
        } catch (\Throwable $e) {
            return $e->getMessage();
        }
    }


    public function delete($id)
    {

        try {
            LibelleDepense::find($id)->forceDelete();
            return response()->json([
                'status' => 200,
            ]);
        } catch (\Throwable $e) {
            return $e->getMessage();
        }
    }
}
