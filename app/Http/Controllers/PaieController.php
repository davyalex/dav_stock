<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Paie;
use App\Models\Depense;
use App\Models\Employe;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\CategorieDepense;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class PaieController extends Controller
{
    //
    public function index()
    {

        try {
            $data_paie = Paie::with('employe')->orderBy('created_at', 'DESC')->get();
            $data_employe = Employe::active()->get();
            $data_employe = $data_employe->sortBy('nom');

            // recuperer les libelle depense de la categorie charge de personnel

            $categorie_depense = CategorieDepense::where('slug', 'charges-de-personnel')->first();
            $type_paie = $categorie_depense->libelleDepenses()->get();
            // dd($libelle_depense->toArray());

            // je veux la liste des mois avec leur clé
            $mois = [
                1 => 'Janvier',
                2 => 'Février',
                3 => 'Mars',
                4 => 'Avril',
                5 => 'Mai',
                6 => 'Juin',
                7 => 'Juillet',
                8 => 'Août',
                9 => 'Septembre',
                10 => 'Octobre',
                11 => 'Novembre',
                12 => 'Décembre'
            ];
            return view('backend.pages.rh.paie.index', compact('data_paie', 'data_employe', 'type_paie', 'mois'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }


    public function store(Request $request)
    {


        try {

            $data =  $request->validate([
                'employe_id' => 'required',
                'montant' => 'required',
                'statut' => 'required',
                'mois' => 'required',
                'annee' => 'required',
                'type_paie' => 'required',
                'date_paiement',
            ]);

            // date de paiement en fonction du mois et de l'annee chaque mois le 5 de chaque mois
            $date_depense= Carbon::parse($request->annee . '-' . $request->mois. '-'.'05');

            $code = "P-" . strtoupper(Str::random(5));
            $data_paie = Paie::firstOrCreate($data, ['code' => $code,  'date_paiement' =>$date_depense]);

            // Enregistrer la paie come depense
            $categorie_depense = CategorieDepense::where('slug', 'charges-de-personnel')->first();

            Depense::firstOrCreate([
                'categorie_depense_id' => $categorie_depense->id,
                'libelle_depense_id' => $request->type_paie,
                'montant' => $request->montant,
                'date_depense' =>  $data_paie->date_paiement,
                'paie_id' => $data_paie->id,
                'user_id' => Auth::id()
            ]);

            Alert::success('Operation réussi', 'Success Message');
            return back();
        } catch (\Throwable $e) {
            return $e->getMessage();
        }
    }



    public function update(Request $request, $id)
    {

        try {
            $data =  $request->validate([
                'employe_id' => 'required',
                'montant' => 'required',
                'statut' => 'required',
                'mois' => 'required',
                'annee' => 'required',
                'type_paie' => 'required',
                'date_paiement',
            ]);

            $data_paie = tap(Paie::find($id))->update($data, ['date_paiement' => Carbon::now()]);

            // Enregistrer la paie come depense
            $categorie_depense = CategorieDepense::where('slug', 'charges-de-personnel')->first();

            // mettre a jour la depense
            Depense::where('paie_id', $data_paie->id)->update([
                'categorie_depense_id' => $categorie_depense->id,
                'libelle_depense_id' =>   $data_paie->type_paie,
                'montant' =>  $data_paie->montant,
                'date_depense' =>  $data_paie->date_paiement,
                'paie_id' => $data_paie->id,
                'user_id' => Auth::id()
            ]);

            Alert::success('Operation réussi', 'Success Message');
            return back();
        } catch (\Throwable $e) {
            return $e->getMessage();
        }
    }


    public function delete($id)
    {
        try {
            Paie::find($id)->delete();
            return response()->json([
                'status' => 200,
            ]);
        } catch (\Throwable $e) {
            $e->getMessage();
        }
    }
}
