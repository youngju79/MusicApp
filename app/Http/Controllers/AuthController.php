<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function loginForm()
    {
        return view('auth.login');
    }
    public function login(Request $request)
    {
        $loginWasSuccessful = Auth::attempt([
            'email' => $request->input('email'),
            'password' => $request->input('password')
        ]);
        if($loginWasSuccessful){
            return redirect()->route('profile.index');
        }
        else{
            return redirect()->route('auth.loginForm')->with('error', 'Invalid credentials.');
        }
    }
    public function logout()
    {
        Auth::logout();
        return redirect()->route('invoice.index');
    }
}
