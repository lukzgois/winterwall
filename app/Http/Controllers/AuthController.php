<?php

namespace App\Http\Controllers;

use App\Domain\Auth\PasswordResetRepository;
use App\Domain\Users\UserRepository;
use App\Http\Requests\Auth\Login;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    /**
     * Show the login form
     * @return Illuminate/View/View
     */
    public function index()
    {
        return view('login.index');
    }

    /**
     * Login the user
     *
     * @param  Login  $request
     * @return Illuminate/View/View
     */
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

    /**
     * Logout the user
     *
     * @return Illuminate\Http\Response
     */
    public function logout()
    {
        Auth::logout();

        return redirect()->route('login.index');
    }

    /**
     * Show the forgot password form
     *
     * @return Illuminate\View\View
     */
    public function forgotPasswordForm()
    {
        return view('login.forgot-password');
    }

    /**
     * Send the reset link to the user email.
     *
     * @param  Request                 $request
     * @param  UserRepository          $repository
     * @param  PasswordResetRepository $passwordRepo
     *
     * @return Illuminate\Http\Response
     */
    public function forgotPassword(
        Request $request,
        UserRepository $repository,
        PasswordResetRepository $passwordRepo
    ) {
        $user = $repository->findBy('email', $request->email);

        if (!$user) {
            return redirect()->back()
                ->withErrors([
                    'email' => 'Não encontramos o email informado em nosso sistema.'
                ]);
        }

        $token = $passwordRepo->generateResetToken($user);

        Mail::send('emails.auth.password-reset', [
            'user' => $user,
            'token' => $token->token
        ], function ($m) use ($user) {
            $m->to($user->email)->subject(trans('emails.forgot-password.subject'));
        });

        return redirect()->back()
                ->with('success', 'Um link para redefinição de senha foi enviado para o seu e-mail.');
    }
}
