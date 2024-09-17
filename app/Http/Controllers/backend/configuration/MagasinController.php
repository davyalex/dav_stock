<?php

namespace App\Http\Controllers\backend\configuration;

use App\Models\Magasin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;

class MagasinController extends Controller
{
    //
    //
    public function index()
    {

        $data_magasin = Magasin::get();
        $data_magasin->sortBy('nom');

        return view('backend.pages.configuration.Magasin.index', compact('data_magasin'));
    }


    public function store(Request $request)
    {


        try {
            $data =  $request->validate([
                'nom' => 'required',
            ]);
            $data_magasin = Magasin::firstOrCreate($data);

            Alert::success('Operation réussi', 'Success Message');
            return back();
        } catch (\Throwable $e) {
            return $e->getMessage();
        }
    }


    public function update(Request $request, $id)
    {

        try {
            $data_magasin = tap(Magasin::find($id))->update([
                'nom' => $request['nom'],

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
            Magasin::find($id)->delete();
            return response()->json([
                'status' => 200,
            ]);
        } catch (\Throwable $e) {
            $e->getMessage();
        }
    }
}
