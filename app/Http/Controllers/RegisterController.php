<?php

namespace App\Http\Controllers;

use App\Domain\Users\UserRepository;
use App\Http\Requests\Register\Register;
use Auth;

class RegisterController extends Controller
{
    /**
     * Show the register form
     *
     * @return Illuminate\View\View
     */
    public function index()
    {
        return view('register.index');
    }

    /**
     * Register a new user
     *
     * @param  Register       $request
     * @param  UserRepository $repository
     *
     * @return Illuminate\Http\Response
     */
    public function store(
        Register $request,
        UserRepository $repository
    ) {
        $user = $repository->create($request->all());
        Auth::login($user);

        return redirect()->route('dashboard.index');
    }
}
