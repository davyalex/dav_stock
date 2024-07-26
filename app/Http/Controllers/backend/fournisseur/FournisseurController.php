<?php

namespace App\Http\Controllers\backend\fournisseur;

use App\Models\Fournisseur;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;

class FournisseurController extends Controller
{
    //
    public function index()
    {

        $data_fournisseur = Fournisseur::with('media')->get();
        $data_fournisseur->sortBy('nom');

        return view('backend.pages.fournisseur.index', compact('data_fournisseur'));
    }


    public function store(Request $request)
    {


        try {
            $data =  $request->validate([
                'nom' => 'required',
                'email' => '',
                'adresse' => '',
                'telephone' => '',
                'image' => '',
            ]);
            $data_fournisseur = Fournisseur::firstOrCreate($data);
            if (request()->hasFile('image')) {
                $data_fournisseur->addMediaFromRequest('image')->toMediaCollection('FournisseurImage');
            }

            Alert::success('Operation réussi', 'Success Message');
            return back();
        } catch (\Throwable $e) {
            return $e->getMessage();
        }
    }


    public function update(Request $request, $id)
    {

        try {
            $data_fournisseur = tap(Fournisseur::find($id))->update([
                'nom' => $request['nom'],
                'telephone' => $request['telephone'],
                'email' => $request['email'],
                'adresse' => $request['adresse'],
            ]);

            if (request()->hasFile('image')) {
                $data_fournisseur->clearMediaCollection('FournisseurImage');
                $data_fournisseur->addMediaFromRequest('image')->toMediaCollection('FournisseurImage');
            }

            Alert::success('Opération réussi', 'Success Message');
            return back();
        } catch (\Throwable $e) {
            $e->getMessage();
        }
    }


    public function delete($id)
    {
        try {
            Fournisseur::find($id)->delete();
            return response()->json([
                'status' => 200,
            ]);
        } catch (\Throwable $e) {
            $e->getMessage();
        }
    }
}
