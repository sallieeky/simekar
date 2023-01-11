<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $user = User::where('role', '!=', 'admin')->get();
        return view('master-data.user', compact('user'));
    }

    public function tambah(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'email' => 'required|email|unique:users,email',
            'no_hp' => 'required|numeric',
            'password' => 'required|min:8',
            'password_confirmation' => 'required|same:password'
        ], [
            'nama.required' => 'Nama tidak boleh kosong',
            'email.required' => 'Email tidak boleh kosong',
            'email.email' => 'Email tidak valid',
            'email.unique' => 'Email sudah terdaftar',
            'no_hp.required' => 'No HP tidak boleh kosong',
            'no_hp.numeric' => 'No HP harus angka',
            'password.required' => 'Password tidak boleh kosong',
            'password.min' => 'Password minimal 8 karakter',
            'password_confirmation.required' => 'Konfirmasi password tidak boleh kosong',
            'password_confirmation.same' => 'Konfirmasi password tidak sama',
        ]);

        $user = new User;
        $user->nama = $request->nama;
        $user->email = $request->email;
        $user->no_hp = $request->no_hp;
        $user->password = bcrypt($request->password);
        $user->save();

        return redirect()->back()->with('success', 'Berhasil menambah data');
    }
    public function get(User $user)
    {
        return $user;
    }
    public function edit(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'email' => 'required|email|unique:users,email,' . $request->id,
            'no_hp' => 'required|numeric',
        ], [
            'nama.required' => 'Nama tidak boleh kosong',
            'email.required' => 'Email tidak boleh kosong',
            'email.email' => 'Email tidak valid',
            'email.unique' => 'Email sudah terdaftar',
            'no_hp.required' => 'No HP tidak boleh kosong',
            'no_hp.numeric' => 'No HP harus angka',
        ]);

        $user = User::find($request->id);
        $user->nama = $request->nama;
        $user->email = $request->email;
        $user->no_hp = $request->no_hp;
        $user->save();

        return redirect()->back()->with('success', 'Berhasil mengubah data');
    }

    public function delete(Request $request)
    {
        $user = User::find($request->id);
        $user->delete();

        return redirect()->back()->with('success', 'Berhasil menghapus data');
    }
}
