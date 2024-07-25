<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use Symfony\Component\HttpFoundation\Response;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::user() && in_array(Auth::user()->role, ['developpeur', 'webmaster', 'administrateur', 'gestionnaire' , 'chef de projet'])) {
            return $next($request);
        } else {
            Alert::error('Access non autorisé', 'Error Message');

            return redirect()->route('admin.login')->withError('Autorisation echoué');
        }
    }
}
