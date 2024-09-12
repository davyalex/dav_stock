<?php

namespace App\Http\Controllers\site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthUserController extends Controller
{
    //
    public function register(Request $request){
            try {

                if (request()->method()=='GET') {
                    return view('site.sections.user-auth.login-register');
                }
                
            } catch (\Throwable $e) {
                return $e->getMessage();
            }
    }
}
