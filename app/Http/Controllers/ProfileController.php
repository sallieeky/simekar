<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function profile()
    {
        $user = auth()->user();
        return view('profile', compact('user'));
    }
    public function ubahDataProfile(Request $request)
    {

        $request->validate([
            'no_hp' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10|max:20|unique:users,no_hp,' . Auth::user()->id,
        ], [
            'no_hp.required' => 'No HP tidak boleh kosong',
            'no_hp.regex' => 'No HP harus berupa angka',
            'no_hp.min' => 'No HP minimal 10 digit',
            'no_hp.max' => 'No HP maximal 20 digit',
            'no_hp.unique' => 'No HP sudah digunakan, coba nomor yang lain',
        ]);

        User::where('id', auth()->user()->id)->update([
            'no_hp' => $request->no_hp,
        ]);

        return redirect()->back()->with('success', 'Berhasil mengubah data');
    }

    public function ubahPassword()
    {
        $user = auth()->user();
        return view('ubah-password', compact('user'));
    }

    public function ubahPasswordPost(Request $request)
    {
        // validasi password_lama, password_baru, konfirmasi_password_baru
        $request->validate([
            'password_lama' => 'required|min:8',
            'password_baru' => 'required|min:8',
            'konfirmasi_password_baru' => 'required|same:password_baru',
        ], [
            'password_lama.required' => 'Password lama tidak boleh kosong',
            'password_lama.min' => 'Password lama minimal 8 karakter',
            'password_baru.required' => 'Password baru tidak boleh kosong',
            'password_baru.min' => 'Password baru minimal 8 karakter',
            'konfirmasi_password_baru.required' => 'Konfirmasi password baru tidak boleh kosong',
            'konfirmasi_password_baru.same' => 'Konfirmasi password baru tidak sama',
        ]);

        if (Hash::check($request->password_lama, auth()->user()->password)) {
            User::where('id', auth()->user()->id)->update([
                'password' => bcrypt($request->password_baru),
            ]);

            Auth::logout();
            return redirect('/login')->with('ubah_password', 'Berhasil mengubah password');
        } else {
            return redirect()->back()->with('error', 'Password lama tidak sesuai');
        }
    }
}
