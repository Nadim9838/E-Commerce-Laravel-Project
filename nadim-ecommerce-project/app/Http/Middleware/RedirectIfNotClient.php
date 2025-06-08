<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfNotClient
{
    /**
     * Handle an incoming request.
     *
     * @param
     * @param  \Closure
     * @param  string|null
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $guard = 'client')
    {
        if (!Auth::guard($guard)->check()) {
            // Store intended URL for redirect after login
            if (!$request->is('user-login')) {
                session()->put('url.intended', $request->url());
            }
            
            return redirect()->route('user-login')->with('error', 'Please login to access this page.');
        }

        return $next($request);
    }
}