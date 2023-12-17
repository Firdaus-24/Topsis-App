<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function index()
    {
        return view('register.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3|max:255|unique:users,name',
            'email' => 'required|email:dns|unique:users,email',
            'password' => 'required|min:3'
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        return redirect('/')->with('success', 'data berhasil didaftarkan');
    }
}
