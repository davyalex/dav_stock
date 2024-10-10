<?php

namespace App\Http\Controllers\backend\depense;

use App\Models\Depense;
use Illuminate\Http\Request;
use App\Models\LibelleDepense;
use App\Models\CategorieDepense;
use App\Http\Controllers\Controller;
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
            $categorie_depense = CategorieDepense::whereNotIn('slug', ['achats'])->get();
            return view('backend.pages.depense.index', compact('data_depense', 'categorie_depense'));
        } catch (\Throwable $th) {
            //throw $th;
            return $th->getMessage();
        }
    }


    public function store(Request $request)
    {
        try {
            // dd($request->all());

            $data_libelle = LibelleDepense::whereId($request->categorie_depense)->first();
            $data_categorie = CategorieDepense::whereId($request->categorie_depense)->first();

            $libelle = '';
            $categorie = '';
            // dd($data_categorie->toArray());

            if ($data_libelle) {
                $libelle =  $data_libelle->id;
                $categorie =  $data_libelle->categorie_depense_id;
            } elseif ($data_categorie) {
                $categorie =  $data_categorie->id;
                $libelle = null;
            }

            $data = $request->validate([
                'libelle' => '',
                'categorie_depense' => 'required',
                'montant' => 'required',
                'description' => '',
                'date_depense' => 'required',
            ]);

            $data_count = Depense::count();

            $data_depense = Depense::firstOrCreate([
                'categorie_depense_id' => $categorie,
                'libelle_depense_id' => $libelle,
                'libelle' => $request->libelle,
                'montant' => $request->montant,
                'description' => $request->description,
                'date_depense' => $request->date_depense,
                'user_id' => Auth::id()
            ]);

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
                'libelle' => '',
                'categorie_depense_id' => '',
                'montant' => 'required',
                'description' => '',
                'date_depense' => 'required',


            ]);


            $data_libelle = LibelleDepense::whereId($request->categorie_depense)->first();
            $data_categorie = CategorieDepense::whereId($request->categorie_depense)->first();

            $libelle = '';
            $categorie = '';
            // dd($data_categorie->toArray());

            if ($data_libelle) {
                $libelle =  $data_libelle->id;
                $categorie =  $data_libelle->categorie_depense_id;
            } elseif ($data_categorie) {
                $categorie =  $data_categorie->id;
                $libelle = null;
            }


            $data_depense = Depense::find($id)->update(
                [
                    'categorie_depense_id' => $categorie,
                    'libelle_depense_id' => $libelle,
                    'libelle' => $request->libelle,
                    'montant' => $request->montant,
                    'description' => $request->description,
                    'date_depense' => $request->date_depense,
                    'user_id' => Auth::id()
                ]
            );

            Alert::success('Opération réussi', 'Success Message');
            return back();
        } catch (\Throwable $e) {
            return $e->getMessage();
        }
    }


    public function delete($id)
    {

        try {
            Depense::find($id)->forceDelete();
            return response()->json([
                'status' => 200,
            ]);
        } catch (\Throwable $e) {
            return $e->getMessage();
        }
    }
}
