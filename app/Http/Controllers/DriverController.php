<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use Illuminate\Http\Request;

class DriverController extends Controller
{
    public function index()
    {
        $driver = Driver::orderBy('isShow', 'asc')->get();
        return view('master-data.driver', compact('driver'));
    }

    public function tampilkan(Request $request, Driver $driver)
    {
        $driver->update([
            'isShow' => !$request->isShow
        ]);
        return true;
    }

    public function get(Driver $driver)
    {
        $html = "
        <input type='hidden' name='id' value='$driver->id'>
        <div class='validation-container mb-4'>
            <div class='form-floating'>
              <input class='form-control form-control-lg ' type='text' id='nama' placeholder='Nama' name='nama' value='$driver->nama'>
              <label for='nama'>Nama</label>
            </div>
          </div>
          <div class='validation-container mb-4'>
            <div class='form-floating'>
              <input class='form-control form-control-lg ' type='text' id='no_hp' placeholder='Nomor Handphone' name='no_hp' value='$driver->no_hp'>
              <label for='no_hp'>Nomor Handphone</label>
            </div>
          </div>
        ";
        return $html;
    }

    public function tambah(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'no_hp' => 'required|numeric',
        ], [
            'nama.required' => 'Nama harus diisi',
            'no_hp.required' => 'No HP harus diisi',
            'no_hp.numeric' => 'No HP harus berupa angka',
        ]);

        Driver::create([
            'nama' => $request->nama,
            'no_hp' => $request->no_hp,
        ]);

        return redirect()->back()->with('success', 'Berhasil menambahkan driver');
    }

    public function edit(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'no_hp' => 'required|numeric',
        ], [
            'nama.required' => 'Nama harus diisi',
            'no_hp.required' => 'No HP harus diisi',
            'no_hp.numeric' => 'No HP harus berupa angka',
        ]);

        Driver::find($request->id)->update([
            'nama' => $request->nama,
            'no_hp' => $request->no_hp,
        ]);

        return redirect()->back()->with('success', 'Berhasil mengubah driver');
    }

    public function delete(Request $request)
    {
        Driver::find($request->id)->delete();
        return redirect()->back()->with('success', 'Berhasil menghapus driver');
    }
}
