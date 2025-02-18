<?php

namespace App\Http\Controllers;

use App\Models\Poste;
use App\Models\Employe;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class EmployeController extends Controller
{
    //

    public function index()
    {

        try {
            $data_employe = Employe::with('poste')->orderBy('created_at', 'DESC')->get();
            $data_poste = Poste::get();


            return view('backend.pages.rh.employe.index', compact('data_poste', 'data_employe'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }


    public function store(Request $request)
    {


        try {
            $data = $request->validate([
                'nom' => 'required',
                'prenom' => 'required',
                'poste_id' => 'nullable',
                'email' => 'nullable|email',
                'telephone' => 'nullable',
                'adresse' => 'nullable',
                'date_embauche' => 'nullable|date',
                'salaire_base' => 'nullable|numeric',
                'statut' => 'required',
            ]);

            // Générer un code unique pour l'employé
            $data['code'] = "ECJ-" . strtoupper(Str::random(5));

            // Vérifier et créer l'employé si le code n'existe pas encore
            $employe = Employe::firstOrCreate(['code' => $data['code']], $data);

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
            $data = $request->validate([
                'nom' => 'required',
                'prenom' => 'required',
                'poste_id' => 'nullable',
                'email' => 'nullable|email',
                'telephone' => 'nullable',
                'adresse' => 'nullable',
                'date_embauche' => 'nullable|date',
                'salaire_base' => 'nullable|numeric',
                'statut' => 'required',
            ]);

            tap(Employe::find($id))->update($data);

            Alert::success('Opération réussi', 'Success Message');
            return back();
        } catch (\Throwable $e) {
            $e->getMessage();
        }
    }

    public function delete($id)
    {
        try {
            Employe::find($id)->delete();
            return response()->json([
                'status' => 200,
            ]);
        } catch (\Throwable $e) {
            $e->getMessage();
        }
    }
}
