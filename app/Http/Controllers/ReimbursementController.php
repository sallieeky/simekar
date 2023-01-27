<?php

namespace App\Http\Controllers;

use App\Models\Kendaraan;
use App\Models\Reimbursement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReimbursementController extends Controller
{
    public function pengajuan()
    {
        if (Auth::user()->role == 'user') {
            $kendaraan = Kendaraan::all();
            return view('reimbursement.user.pengajuan', compact('kendaraan'));
        } else {
            // return view('peminjaman.admin.pengajuan', compact('data'));
        }
    }

    public function pengajuanPost(Request $request)
    {
        $request->validate([
            'kendaraan_id' => 'required',
            'km_tempuh' => 'required|numeric'
        ], [
            'kendaraan_id.required' => 'Kendaraan harus dipilih',
            'km_tempuh.required' => 'KM tempuh tidak boleh kosong',
            'km_tempuh.numeric' => 'KM tempuh harus berupa angka',
        ]);

        Reimbursement::create([
            'user_id' => Auth::user()->id,
            'kendaraan_id' => $request->kendaraan_id,
            'km_tempuh' => $request->km_tempuh,
        ]);

        return back()->with('success', 'Berhasil melakukan pengajuan reimbursement');
    }
}
