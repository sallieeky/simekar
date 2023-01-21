<?php

namespace App\Http\Controllers;

use App\Models\Kendaraan;
use Illuminate\Http\Request;

class KendaraanController extends Controller
{

    public function exportPdf()
    {
        $kendaraan = Kendaraan::orderBy('isShow', 'asc')->orderBy('isReady', 'asc')->get();
        $pdf = app('dompdf.wrapper');
        $pdf->loadView('tespdf', compact('kendaraan'));
        return $pdf->stream();
    }

    public function index()
    {
        $kendaraan = Kendaraan::orderBy('isShow', 'asc')->orderBy('isReady', 'asc')->get();
        return view('master-data.kendaraan', compact('kendaraan'));
    }

    public function get(Kendaraan $kendaraan)
    {
        $html = "
        <input type='hidden' name='id' value='$kendaraan->id'>
        <div class='validation-container mb-4'>
            <div class='form-floating'>
            <input class='form-control form-control-lg' type='text' id='no_polisi' placeholder='Nomor Polisi' name='no_polisi' value='$kendaraan->no_polisi'>
            <label for='no_polisi'>Nomor Polisi</label>
            </div>
        </div>
      <div class='validation-container mb-4'>
        <div class='form-floating'>
          <input class='form-control form-control-lg' type='text' id='merk' placeholder='Merk' name='merk' value='$kendaraan->merk'>
          <label for='merk'>Merk</label>
        </div>
      </div>
      <div class='validation-container mb-4'>
        <div class='form-floating'>
          <input class='form-control form-control-lg' type='text' id='tipe' placeholder='Tipe' name='tipe' value='$kendaraan->tipe'>
          <label for='tipe'>Tipe</label>
        </div>
      </div>
        ";
        return $html;
    }

    public function tampilkan(Request $request, Kendaraan $kendaraan)
    {
        $kendaraan->update([
            'isShow' => !$request->isShow,
            'isReady' => !$request->isShow,
        ]);
        return $kendaraan;
    }

    public function tambah(Request $request)
    {
        $request->validate([
            'no_polisi' => 'required|unique:kendaraans,no_polisi',
            'merk' => 'required',
            'tipe' => 'required',
        ], [
            'no_polisi.required' => 'No Polisi tidak boleh kosong',
            'no_polisi.unique' => 'No Polisi sudah terdaftar',
            'merk.required' => 'Merk tidak boleh kosong',
            'tipe.required' => 'Tipe tidak boleh kosong',
        ]);

        $kendaraan = new Kendaraan;
        $kendaraan->no_polisi = $request->no_polisi;
        $kendaraan->merk = $request->merk;
        $kendaraan->tipe = $request->tipe;
        $kendaraan->save();

        return redirect()->back()->with('success', 'Berhasil menambah data');
    }

    public function edit(Request $request)
    {
        $request->validate([
            'no_polisi' => 'required|unique:kendaraans,no_polisi,' . $request->id,
            'merk' => 'required',
            'tipe' => 'required',
        ], [
            'no_polisi.required' => 'No Polisi tidak boleh kosong',
            'no_polisi.unique' => 'No Polisi sudah terdaftar',
            'merk.required' => 'Merk tidak boleh kosong',
            'tipe.required' => 'Tipe tidak boleh kosong',
        ]);

        $kendaraan = Kendaraan::find($request->id);
        $kendaraan->no_polisi = $request->no_polisi;
        $kendaraan->merk = $request->merk;
        $kendaraan->tipe = $request->tipe;
        $kendaraan->save();

        return redirect()->back()->with('success', 'Berhasil mengubah data');
    }

    public function delete(Request $request)
    {
        $kendaraan = Kendaraan::find($request->id);
        $kendaraan->delete();
        return redirect()->back()->with('success', 'Berhasil menghapus data');
    }
}
