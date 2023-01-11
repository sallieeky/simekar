<?php

namespace App\Http\Controllers;

use App\Models\Kendaraan;
use Illuminate\Http\Request;

class KendaraanController extends Controller
{
    public function index()
    {
        $kendaraan = Kendaraan::orderBy('isShow', 'asc')->get();
        return view('master-data.kendaraan', compact('kendaraan'));
    }

    public function tampilkan(Request $request, Kendaraan $kendaraan)
    {
        $kendaraan->update([
            'isShow' => !$request->isShow
        ]);
        return $kendaraan;
    }
}
