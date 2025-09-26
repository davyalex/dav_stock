<?php

namespace App\Http\Controllers\backend\user;

use App\Models\User;
use App\Models\Caisse;
use App\Models\Setting;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use App\Models\HistoriqueCaisse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use RealRashid\SweetAlert\Facades\Alert;

class AdminController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth');
    //     // Vérifier si l'utilisateur a le rôle 'caisse' ou 'supercaisse'
    //     $this->middleware(function ($request, $next) {
    //         if ($request->user()->hasRole(['caisse', 'supercaisse'])) {
    //             // Vérifier si l'utilisateur n'a pas sélectionné de caisse
    //             if (Auth::user()->caisse_id === null) {
    //                 // Rediriger vers la page de sélection de caisse
    //                 return redirect()->route('caisse.select')->with('warning', 'Veuillez sélectionner une caisse avant d\'accéder à l\'application.');
    //             }
    //         }
    //         return $next($request);
    //     });
    // }
    //
    public function login(Request $request)
    {

        if (request()->method() == 'GET') {
            return view('backend.pages.auth-admin.login');
        } elseif (request()->method() == 'POST') {
            $credentials = $request->validate([
                'email' => ['required',],
                'password' => ['required'],
            ]);
            if (Auth::attempt($credentials)) {
                Alert::success('Connexion réussi,  Bienvenue  ' . Auth::user()->first_name, 'Success Message');
                return redirect()->route('dashboard.index');
            } else {
                // Alert::error('Email ou mot de passe incorrect' , 'Error Message');
                // return back();
                return back()->withError('Email ou mot de passe incorrect');
            }
        }
    }



    //logout admin
    public function logout(Request $request)
    {
        $user = Auth::user();

        // //on verifie si l'utilisateur a une caisse non cloturer si oui la cloturer avant de se deconnecter
        // $ventes = $user->ventes->where('user_id', $user->id)->where('caisse_id', $user->caisse_id)->where('statut_cloture', false)->first();
        // if ($ventes) {
        //     Alert::success('Vous devez cloturer la caisse avant de vous deconnecter', 'warning Message');

        //     return Redirect()->route('vente.index');
        // }


        // Si l'utilisateur a une caisse active, la désactiver
        if ($user->caisse_id) {

            // Mettre a Null la session de vente et desactiver la caisse
            Caisse::whereId($user->caisse_id)->update([
                'statut' => 'desactive',
                'session_date_vente' => null
            ]);
            
            // mettre caisse_id a null
            User::whereId($user->id)->update([
                'caisse_id' => null,
            ]);

            //mise a jour dans historiquecaisse pour fermeture de caisse
            HistoriqueCaisse::where('user_id', $user->id)
                ->where('caisse_id', $user->caisse_id)
                ->whereNull('date_fermeture')
                ->update([
                    'date_fermeture' => now(),
                ]);
        }


        Auth::logout();
       
        Alert::success('Vous etes deconnecté', 'Success Message');
        return Redirect()->route('admin.login');
    }



    //register admin

    public function index()
    {

        $data_role = Role::where('name', '!=', 'client')->get();

        $data_admin = User::with('roles')->whereHas('roles', function ($query) {
            $query->where('name', '!=', 'client');
        })->get();
        // dd($data_admin->toArray());

        return view('backend.pages.auth-admin.register.index', compact('data_admin', 'data_role'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'last_name' => 'required|string|max:255',
            'first_name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'nullable',
            'role' => 'required',
            'password' => 'required|min:6',
        ]);

        // Vérification email
        if (User::where('email', $request->email)->exists()) {
            Alert::error('Erreur', 'Cet email existe déjà.');
            return back()->withInput();
        }

        // Vérification téléphone
        if ($request->phone && User::where('phone', $request->phone)->exists()) {
            Alert::error('Erreur', 'Ce numéro de téléphone existe déjà.');
            return back()->withInput();
        }

        try {
            $data_user = User::create([
                'last_name' => $request['last_name'],
                'first_name' => $request['first_name'],
                'email' => $request->email,
                'phone' => $request->phone,
                'role' => $request->role,
                'password' => Hash::make($request->password),
            ]);

            $data_user->assignRole($request['role']);

            Alert::success('Opération réussie', 'Succès');
            return back();
        } catch (\Exception $e) {
            Alert::error('Erreur', $e->getMessage());
            return back()->withInput();
        }
    }



    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'last_name' => 'required|string|max:255',
            'first_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'phone' => 'nullable|unique:users,phone,' . $id,
            'role' => 'required',
            'password' => 'nullable|min:6',
        ]);

        try {
            $updateData = [
                'last_name' => $request['last_name'],
                'first_name' => $request['first_name'],
                'email' => $request->email,
                'phone' => $request->phone,
                'role' => $request->role,
            ];

            if ($request->filled('password')) {
                $updateData['password'] = Hash::make($request->password);
            }

            $user->update($updateData);

            if ($request->has('role')) {
                $user->syncRoles($request['role']);
            }

            Alert::success('Opération réussie', 'Les informations ont été mises à jour');
            return back();
        } catch (\Exception $e) {
            Alert::error('Erreur', 'Une erreur est survenue lors de la mise à jour : ' . $e->getMessage());
            return back()->withInput();
        }
    }

    public function delete($id)
    {
        User::find($id)->forceDelete();
        return response()->json([
            'status' => 200,
        ]);
    }



    public function profil($id)
    {

        $data_admin = User::find($id);
        $data_role = Role::get();
        return view('backend.pages.auth-admin.register.profil', compact('data_admin', 'data_role'));
    }

    public function changePassword(Request $request)
    {

        $user = Auth::user();

        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|string',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->old_password, $user->password)) {

            Alert::error('Ancien mot de passe incorrect', 'Error Message');
            return back();
        }

        User::whereId($user->id)->update([
            'password' => Hash::make($request->new_password)
        ]);

        Alert::success('Operation réussi', 'Success Message');
        return back();
    }
}
