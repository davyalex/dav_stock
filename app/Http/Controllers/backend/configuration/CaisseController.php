<?php

namespace App\Http\Controllers\backend\configuration;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Caisse;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\HistoriqueCaisse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class CaisseController extends Controller
{
    //
    //
    public function index()
    {

        $data_caisse = Caisse::get();
        $data_caisse->sortBy('libelle');

        return view('backend.pages.configuration.caisse.index', compact('data_caisse'));
    }


    public function store(Request $request)
    {
        try {
            $data =  $request->validate([
                'libelle' => 'required',
            ]);
            $data_caisse = Caisse::firstOrCreate([
                'code' => 'C-' . strtoupper(Str::random(5)),
                'libelle' => $request['libelle'],
                'description' => $request['description'],
                'statut' => 'desactive',

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
            $data_caisse = tap(Caisse::find($id))->update([
                'libelle' => $request['libelle'],
                'description' => $request['description'],
            ]);

            Alert::success('Opération réussi', 'Success Message');
            return back();
        } catch (\Throwable $e) {
            $e->getMessage();
        }
    }


    // public function delete($id)
    // {
    //     try {
    //         Caisse::find($id)->delete();
    //         return response()->json([
    //             'status' => 200,
    //         ]);
    //     } catch (\Throwable $e) {
    //         $e->getMessage();
    //     }
    // }


    public function selectCaisse(Request $request)
    {
        try {
            if (Auth::check()) {
                if (request()->method() == 'GET') {
                    $data_caisse = Caisse::whereStatut('desactive')->get();
                    return view('backend.pages.auth-admin.select-caisse', compact('data_caisse'));
                } elseif (request()->method() == 'POST') {
                    $user = Auth::user();

                    // on verifie si l'utilisateur est connecté a une caisse 
                    //un utilisateur ne peux pas se connecter à plusieurs caisse a la fois

                    if ($user->caisse_id) {
                        $oldCaisse = Caisse::find($user->caisse_id);
                        $oldCaisse->statut = 'desactive';
                        $oldCaisse->save();
                    }

                    // Mettre à jour la caisse de l'utilisateur
                    Caisse::whereId($request->caisse)->update([
                        'statut' => 'active',
                    ]);

                    User::whereId($user->id)->update([
                        'caisse_id' => $request->caisse,
                    ]);


                    // Enregistrer dans l'historique
                    HistoriqueCaisse::create([
                        'user_id' => $user->id,
                        'caisse_id' => $request->caisse,
                        'date_ouverture' => Carbon::now()
                    ]);

                    Alert::success('Connexion réussi,  Bienvenue  ' . Auth::user()->first_name, 'Success Message');
                    return redirect()->route('dashboard.index');
                }
            }
        } catch (\Throwable $th) {
            return  $th->getMessage();
        }
    }


 
}
