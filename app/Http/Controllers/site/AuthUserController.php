<?php

namespace App\Http\Controllers\site;

use App\Models\User;
use App\Models\Commande;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class AuthUserController extends Controller
{
    //
    public function register(Request $request)
    {
        try {

            if (request()->method() == 'GET') {
                return view('site.sections.user-auth.register');
            } elseif (request()->method() == 'POST') {
                // dd($request->toArray());
                $data = $request->validate([
                    'last_name' => 'required',
                    'first_name' => 'required',
                    'phone' => 'required|unique:users',
                ]);

                $user = User::firstOrCreate([
                    'phone' => $request['phone'],
                    'last_name' => $request['last_name'],
                    'first_name' => $request['first_name'],
                    'role' => 'client',

                ]);

                // affecte le role client
                if ($user) {
                    $user->assignRole('client');
                }


                // //redirection apres connexion
                if (session('cart')) {
                    $url = 'caisse';  // si le panier n'est pas vide on redirige vers la page checkout
                } else {
                    $url = '/';   // sinon on redirige vers l'accueil
                }
                // on connecte l'utilisateur
                auth()->login($user); //Auth::login($user)

                Alert::toast('Connexion réussi', 'success');
                return redirect()->away($url);
            }
        } catch (\Throwable $e) {
            if ($e->getMessage() == 'The phone has already been taken.') {
                Alert::error('Le numero est déjà associé à un compte', 'Une erreur s\'est produite');
                return back();
            } else {
                Alert::error($e->getMessage(),  'Une erreur s\'est produite');
                return back();
            }
        }
    }


    public function login(Request $request)
    {
        try {

            if (request()->method() == 'GET') {
                return view('site.sections.user-auth.login');
            } elseif (request()->method() == 'POST') {
                $request->validate([
                    'phone' => 'required',
                    // 'password' => 'required',
                ]);

                // Rechercher l'utilisateur par son numéro de téléphone
                $user = User::where('phone', $request->phone)->first();

                if ($user) {
                    // Connecter l'utilisateur sans mot de passe
                    Auth::login($user);

                    if (session('cart')) {
                        $url = 'caisse';  // si le panier n'est pas vide on redirige vers la page checkout
                    } else {
                        $url = '/';   // sinon on redirige vers l'accueil
                    }

                    Alert::toast('Connexion réussi', 'success');
                    return redirect()->away($url);
                } else {
                    Alert::error('Identifiants(Contact) incorrects', 'Une erreur s\'est produite');
                    return back();
                }
            }
        } catch (\Throwable $e) {
            Alert::error($e->getMessage(), 'Error Message');
            return back();
        }
    }


    public function profile() {
        return view('site.sections.user-auth.profile');

    }


    public function commande() {
        $commandes = Commande::where('user_id' , Auth::id())->get();
        return view('site.sections.user-auth.commande' , compact('commandes'));
    }


    public function logout()
    {
        Auth::logout();
        Alert::toast('Vous etes deconnecté', 'success');
        return Redirect()->route('accueil');
    }
}
