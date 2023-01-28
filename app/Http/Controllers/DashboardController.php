<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use App\Models\Kendaraan;
use App\Models\Peminjaman;
use App\Models\Reimbursement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $peminjaman = Peminjaman::where('user_id', Auth::user()->id)->where('status', '!=', 'selesai')->first();
        $antrian = Peminjaman::where('status', 'menunggu')->orderBy('created_at', 'asc')->get();

        $data = [
            "kendaraan" => Kendaraan::where("isShow", 1)->where("isReady", 1)->count(),
            "driver" => Driver::where("isShow", 1)->where("isReady", 1)->count(),
            "status_peminjaman" => Peminjaman::where("user_id", Auth::user()->id)->where("status", "!=", "selesai")->pluck("status")->first(),
            "status_reimburse" => Reimbursement::where('user_id', Auth::user()->id)->where('status', '!=', 'selesai')->first(),

            "kendaraan_terpakai" => Kendaraan::where("isShow", 1)->where("isReady", 0)->count(),
            "driver_terpakai" => Driver::where("isShow", 1)->where("isReady", 0)->count(),
            "konfirmasi_reimburse" => null,
        ];

        return view("dashboard", compact('peminjaman', 'antrian', 'data'));
    }
}
