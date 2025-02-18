<?php

namespace App\Http\Controllers;

use App\Models\Poste;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class PosteController extends Controller
{
    //

    public function index()
    {

        $data_poste = Poste::get();
        $data_poste->sortBy('libelle');

        return view('backend.pages.rh.Poste.index', compact('data_poste'));
    }


    public function store(Request $request)
    {


        try {
            $data =  $request->validate([
                'libelle' => 'required',
                'statut' => 'required',
                'description' => '',
            ]);
            $data_Poste = Poste::firstOrCreate($data);

            Alert::success('Operation réussi', 'Success Message');
            return back();
        } catch (\Throwable $e) {
            return $e->getMessage();
        }
    }


    public function update(Request $request, $id)
    {

        try {

            // validation
            $data =  $request->validate([
                'libelle' => 'required',
                'statut' => 'required',
                'description' => '',
            ]);


            $data_Poste = tap(Poste::find($id))->update([
                'libelle' => $request['libelle'],
                'statut' => $request['statut'],
                'description' => $request['description'],

            ]);

            Alert::success('Opération réussi', 'Success Message');
            return back();
        } catch (\Throwable $e) {
            $e->getMessage();
        }
    }


    public function delete($id)
    {
        try {
            Poste::find($id)->delete();
            return response()->json([
                'status' => 200,
            ]);
        } catch (\Throwable $e) {
            $e->getMessage();
        }
    }
}
