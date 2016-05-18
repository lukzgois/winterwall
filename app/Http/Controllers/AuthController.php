<?php

namespace App\Http\Controllers;

use App\Domain\Users\UserRepository;
use App\Http\Requests\Auth\Login;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

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

    public function forgotPasswordForm()
    {
        return view('login.forgot-password');
    }

    public function forgotPassword(Request $request, UserRepository $repository)
    {
        $user = $repository->findBy('email', $request->email);

        if (!$user) {
            return redirect()->back()
                ->withErrors([
                    'email' => 'Não encontramos o email informado em nosso sistema.'
                ]);
        }

        Mail::send('emails.auth.password-reset', ['email' => $user->email], function($m) use ($user) {
            $m->to($user->email)->subject('test');
        });

        return redirect()->back()
                ->with('success', 'Um link para redefinição de senha foi enviado para o seu e-mail.');

        
    }
}
