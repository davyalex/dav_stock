<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use Symfony\Component\HttpFoundation\Response;

class CheckSession
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if the user is authenticated and the session has a 'last_activity_time'
        if (Auth::check()) {
            $lastActivity = $request->session()->get('last_activity_time', time());
            $sessionLifetime = 1 * 60;

            // Check if the session has expired
            if (time() - $lastActivity > $sessionLifetime) {
                // Destroy the session
                Auth::logout();
                Alert::success('Votre session à expiré , veuillez vous connecter à nouveau', 'Success Message');
                return Redirect()->route('admin.login');
            }

            // Update 'last_activity_time'
            $request->session()->put('last_activity_time', time());
        }

        return $next($request);
    }
}
