<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
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
            'no_hp' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10|max:20|unique:users,no_hp',
            'password' => 'required|min:8',
            'password_confirmation' => 'required|same:password'
        ], [
            'nama.required' => 'Nama tidak boleh kosong',
            'email.required' => 'Email tidak boleh kosong',
            'email.email' => 'Email tidak valid',
            'email.unique' => 'Email sudah terdaftar',
            'no_hp.required' => 'No HP tidak boleh kosong',
            'no_hp.regex' => 'No HP harus berupa angka',
            'no_hp.min' => 'No HP minimal 10 digit',
            'no_hp.max' => 'No HP maximal 20 digit',
            'no_hp.unique' => 'No HP sudah digunakan, coba nomor yang lain',
            'password.required' => 'Password tidak boleh kosong',
            'password.min' => 'Password minimal 8 karakter',
            'password_confirmation.required' => 'Konfirmasi password tidak boleh kosong',
            'password_confirmation.same' => 'Konfirmasi password tidak sama',
        ]);

        // $user = new User;
        // $user->nama = $request->nama;
        // $user->email = $request->email;
        // $user->no_hp = $request->no_hp;
        // $user->password = bcrypt($request->password);
        // $user->save();

        $request['password'] = bcrypt($request['password']);
        User::create($request->all());

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
            'no_hp' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10|max:20|unique:users,no_hp,' . $request->id,
            'password' => 'nullable',
            'password_confirmation' => 'nullable|same:password'
        ], [
            'nama.required' => 'Nama tidak boleh kosong',
            'email.required' => 'Email tidak boleh kosong',
            'email.email' => 'Email tidak valid',
            'email.unique' => 'Email sudah terdaftar',
            'no_hp.required' => 'No HP tidak boleh kosong',
            'no_hp.regex' => 'No HP harus berupa angka',
            'no_hp.min' => 'No HP minimal 10 digit',
            'no_hp.max' => 'No HP maximal 20 digit',
            'no_hp.unique' => 'No HP sudah digunakan, coba nomor yang lain',
            'password.min' => 'Password minimal 8 karakter',
            'password_confirmation.same' => 'Konfirmasi password tidak sama',
        ]);

        $user = User::find($request->id);
        $user->nama = $request->nama;
        $user->email = $request->email;
        $user->no_hp = $request->no_hp;
        if ($request->password) {
            $user->password = bcrypt($request->password);
        }
        $user->save();

        return redirect()->back()->with('success', 'Berhasil mengubah data');
    }

    public function delete(Request $request)
    {

        // cek apakah user sedang melakukan peminjaman
        $peminjaman = Peminjaman::where('user_id', $request->id)->where('status', 'dipakai')->first();

        if ($peminjaman) {
            return back()->with('fail', 'User sedang melakukan peminjaman tidak boleh dihapus!');
        }

        $user = User::find($request->id);
        $user->delete();

        return redirect()->back()->with('success', 'Berhasil menghapus data');
    }
}
