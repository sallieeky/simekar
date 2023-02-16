<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function loginPost(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8'
        ], [
            'email.required' => 'Email tidak boleh kosong!',
            'email.email' => 'Email tidak valid!',
            'password.required' => 'Password tidak boleh kosong!',
            'password.min' => 'Password minimal 8 karakter!'
        ]);
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            // store email in session if remember me is checked
            if ($request->remember_me) {
                $request->session()->put('email', $request->email);
                $request->session()->put('password', $request->password);
            } else {
                $request->session()->forget('email');
            }
            return redirect("/");
        } else {
            return back()->with('error', 'Email atau password salah!');
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect("/login");
    }
}
