<?php

namespace App\Http\Controllers;

abstract class Controller
{
    public function login(Request $request) {
        // Validate user inputs
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if(Auth::attempt($credentials)) {
            return view('admin.dashboard');
        }
    }
}
