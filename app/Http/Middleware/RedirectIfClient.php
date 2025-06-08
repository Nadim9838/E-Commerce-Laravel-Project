<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfClient
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
        if (Auth::guard($guard)->check()) {
            // Store intended URL for redirect after login
            if (!$request->is('home')) {
                session()->put('url.intended', $request->url());
            }
            
            return redirect()->route('home')->with('error', 'You are logged in, please logout to access this page.');
        }

        return $next($request);
    }
}