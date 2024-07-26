<?php

namespace App\Http\Controllers\backend\configuration;

use App\Models\Unite;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;

class UniteMesureController extends Controller
{
    //
    public function index()
    {

        $data_unite = Unite::get();
        $data_unite->sortBy('libelle');

        return view('backend.pages.configuration.unite-de-mesure.index', compact('data_unite'));
    }


    public function store(Request $request)
    {


        try {
            $data =  $request->validate([
                'libelle' => 'required',
                'abreviation' => 'required',
            ]);
            $data_unite = Unite::firstOrCreate($data);

            Alert::success('Operation réussi', 'Success Message');
            return back();
        } catch (\Throwable $e) {
            return $e->getMessage();
        }
    }


    public function update(Request $request, $id)
    {

        try {
            $data_unite = tap(Unite::find($id))->update([
                'libelle' => $request['libelle'],
                'abreviation' => $request['abreviation'],

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
            Unite::find($id)->delete();
            return response()->json([
                'status' => 200,
            ]);
        } catch (\Throwable $e) {
            $e->getMessage();
        }
    }
}
