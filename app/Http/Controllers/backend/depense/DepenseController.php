<?php

namespace App\Http\Controllers\backend\depense;

use App\Models\Depense;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\CategorieDepense;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class DepenseController extends Controller
{
    //
    //
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        try {
            $data_depense = Depense::OrderBy('created_at', 'ASC')->get();
            $categorie_depense = CategorieDepense::get();
            return view('backend.pages.depense.index', compact('data_depense', 'categorie_depense'));
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
                'categorie_depense_id' => '',
                'montant' => 'required',
                'description' => '',
               
            ]);

            $data_count = Depense::count();

            $data_depense = Depense::firstOrCreate($data, ['user_id' => Auth::id()]);

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
                'categorie_depense_id' => '',
                'montant' => 'required',
                'description' => '',
               
            ]);


            $data_depense = Depense::find($id)->update($data, ['user_id' => Auth::id()]);

            Alert::success('Opération réussi', 'Success Message');
            return back();
        } catch (\Throwable $e) {
            return $e->getMessage();
        }
    }


    public function delete($id)
    {

        try {
            Depense::find($id)->delete();
            return response()->json([
                'status' => 200,
            ]);
        } catch (\Throwable $e) {
            return $e->getMessage();
        }
    }
}
