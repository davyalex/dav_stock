<?php

namespace App\Http\Controllers\backend\user;

use App\Models\User;
use App\Models\Caisse;
use App\Models\Setting;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;

class AuthAdminController extends Controller
{
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
    public function logout()
    {

        $user = Auth::user();

        // Si l'utilisateur a une caisse active, la désactiver
        if ($user->caisse_id) {

            // niveau caisse
            $caisse = Caisse::find($user->caisse_id);
            $caisse->statut = 'desactive';
            $caisse->save();
            // mettre caisse_id a null
            User::whereId($user->id)->update([
                'caisse_id' => null,
            ]);

        }


        Auth::logout();
        // Session::forget('user_auth');
        Alert::success('Vous etes deconnecté', 'Success Message');
        return Redirect()->route('admin.login');
    }






    //register admin

    public function index()
    {

        $data_role = Role::get();

        $data_admin = User::with('roles')->get();
        // dd($data_admin->toArray());

        return view('backend.pages.auth-admin.register.index', compact('data_admin', 'data_role'));
    }


    public function store(Request $request)
    {

        //on verifie si le nouvel utilisateur est déja dans la BD à partir du phone et email
        $user_verify_phone = User::wherePhone($request['phone'])->first();
        $user_verify_email = User::whereEmail($request['email'])->first();

        if ($user_verify_phone != null) {
            Alert::error('Ce numero de telephone est dejà associé un compte, veuillez utiliser un autre', 'Error Message');
            return back();
        } elseif ($user_verify_email != null) {
            Alert::error('Ce email est dejà associé un compte, veuillez utiliser un autre', 'Error Message');
            return back();
        } else {
            // dd($request);
            // $request->validate([
            //     'name' => 'required',
            //     'phone' => 'required',
            //     'email' => 'required|unique:users',
            //     'password' => 'required',
            // ]);

            $data_user = User::firstOrCreate([
                'last_name' => $request['last_name'],
                'first_name' => $request['first_name'],
                'email' => $request->email,
                'phone' => $request->phone,
                'role' => $request->role,
                'password' => Hash::make($request->password),
            ]);
            if ($request->has('role')) {
                $data_user->assignRole([$request['role']]);
            }

            Alert::success('Operation réussi', 'Success Message');
            return back();
        }
    }



    public function update(Request $request, $id)
    {


        $data_user = tap(User::find($id))->update([
            'last_name' => $request['last_name'],
            'first_name' => $request['first_name'],
            'email' => $request->email,
            'phone' => $request->phone,
            'role' => $request->role,
        ]);

        // DB::table('model_has_roles')->where('model_id', $id)->delete();

        if ($request->has('role')) {
            $data_user->syncRoles($request['role']);
        }


        Alert::success('Operation réussi', 'Success Message');
        return back();
    }

    public function delete($id)
    {
        User::find($id)->delete();
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
