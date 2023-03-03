<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use App\Models\Kendaraan;
use App\Models\Peminjaman;
use Illuminate\Http\Request;

class DriverController extends Controller
{
    public function index()
    {
        $driver = Driver::orderBy('isShow', 'asc')->orderBy('isReady', 'asc')->get();
        return view('master-data.driver', compact('driver'));
    }

    public function tampilkan(Request $request, Driver $driver)
    {
        $cek = Peminjaman::where('driver_id', $driver->id)->where('status', 'dipakai')->first();
        if ($cek) {
            return false;
        }
        $driver->update([
            'isShow' => !$request->isShow,
            'isReady' => !$request->isShow
        ]);

        if ($driver->isShow == 1) {
            $kendaraan = Kendaraan::where('isShow', 1)->where('isReady', 1)->inRandomOrder()->first();
            if ($kendaraan) {
                $cek = Peminjaman::where('status', 'menunggu')->orderBy('created_at', 'asc')->first();
                if ($cek) {
                    $cek->update([
                        'status' => 'dipakai',
                        'driver_id' => $driver->id,
                        'kendaraan_id' => $kendaraan->id,
                    ]);

                    $kendaraan->update([
                        'isReady' => 0,
                    ]);

                    $driver->update([
                        'isReady' => 0,
                    ]);
                }
            }
        }

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
            'no_hp' => 'required|numeric|unique:drivers,no_hp',
        ], [
            'nama.required' => 'Nama harus diisi',
            'no_hp.required' => 'No HP harus diisi',
            'no_hp.numeric' => 'No HP harus berupa angka',
            'no_hp.unique' => 'No HP sudah terdaftar',
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
            'no_hp' => 'required|numeric|unique:drivers,no_hp,' . $request->id,
        ], [
            'nama.required' => 'Nama harus diisi',
            'no_hp.required' => 'No HP harus diisi',
            'no_hp.numeric' => 'No HP harus berupa angka',
            'no_hp.unique' => 'No HP sudah terdaftar',
        ]);

        Driver::find($request->id)->update([
            'nama' => $request->nama,
            'no_hp' => $request->no_hp,
        ]);

        return redirect()->back()->with('success', 'Berhasil mengubah driver');
    }

    public function delete(Request $request)
    {
        $peminjaman = Peminjaman::where('driver_id', $request->id)->where('status', 'dipakai')->first();

        if ($peminjaman) {
            return back()->with('fail', 'Driver yang sedang digunakan tidak boleh dihapus!');
        }

        Driver::find($request->id)->delete();
        return redirect()->back()->with('success', 'Berhasil menghapus driver');
    }
}
