<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;

class AutControlller extends Controller
{
    protected $model;
    protected $view;
    protected $path;

    public function __construct(User $user)
    {
        $this->path     = 'admin';
        $this->model    = $user;
        $this->view     = "auth";
    }

    public function index()
    {
        return  view('login.index');
    }


    public function login(LoginRequest $request)
    {
        $input = $request->all();
        unset($input['_token']);
        if (Auth::attempt($input)) {
            $request->session()->regenerate();

            return redirect('/dashboard');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }


    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
