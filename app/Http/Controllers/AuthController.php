<?php

namespace App\Http\Controllers;

use Auth;
use App\Http\Requests\Auth\Login;

class AuthController extends Controller
{
    public function index()
    {
        return view('login.index');
    }

    public function login(Login $request)
    {
        if (Auth::attempt([
            'email' => $request->email,
            'password' => $request->password
        ])) {
            return redirect()->route('dashboard.index');
        }

        return redirect()->back()
                ->withInput()
                ->withErrors(['email' => 'E-mail e/ou Senha incorretos.']);
    }

    public function logout()
    {
        Auth::logout();

        return redirect()->route('login.index');
    }
}
