<?php

namespace App\Http\Controllers;

use App\Domain\Users\UserRepository;
use App\Http\Requests\Register\Register;
use Illuminate\Http\Request;
use Auth;

class RegisterController extends Controller
{
    public function index()
    {
        return view('register.index');
    }

    public function store(
        Register $request, 
        UserRepository $repository
    ) {
        $user = $repository->create($request->all());
        Auth::login($user);

        return redirect()->route('dashboard.index');        
    }
}
