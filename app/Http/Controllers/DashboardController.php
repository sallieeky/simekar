<?php

namespace App\Http\Controllers;

use App\Models\AsetKendaraan;
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
        $notifikasi = [
            // get aset kendaraan where masa_pajak, masa_stnk, masa_asuransi, tgl_service_rutin in this month and sort by each column descending
            "bulan_ini" => [
                "masa_pajak" => AsetKendaraan::with("kendaraan")->whereMonth('masa_pajak', date('m'))->orderBy('masa_pajak', 'desc')->get(),
                "masa_stnk" => AsetKendaraan::with("kendaraan")->whereMonth('masa_stnk', date('m'))->orderBy('masa_stnk', 'desc')->get(),
                "masa_asuransi" => AsetKendaraan::with("kendaraan")->whereMonth('masa_asuransi', date('m'))->orderBy('masa_asuransi', 'desc')->get(),
                "tgl_service_rutin" => AsetKendaraan::with("kendaraan")->whereMonth('tgl_service_rutin', date('m'))->orderBy('tgl_service_rutin', 'desc')->get(),
            ],
            // get aset kendaraan where masa_pajak, masa_stnk, masa_asuransi, tgl_service_rutin in next month and sort by each column descending
            "bulan_depan" => [
                "masa_pajak" => AsetKendaraan::with("kendaraan")->whereMonth('masa_pajak', date('m', strtotime('+1 month')))->orderBy('masa_pajak', 'desc')->get(),
                "masa_stnk" => AsetKendaraan::with("kendaraan")->whereMonth('masa_stnk', date('m', strtotime('+1 month')))->orderBy('masa_stnk', 'desc')->get(),
                "masa_asuransi" => AsetKendaraan::with("kendaraan")->whereMonth('masa_asuransi', date('m', strtotime('+1 month')))->orderBy('masa_asuransi', 'desc')->get(),
                "tgl_service_rutin" => AsetKendaraan::with("kendaraan")->whereMonth('tgl_service_rutin', date('m', strtotime('+1 month')))->orderBy('tgl_service_rutin', 'desc')->get(),
            ],
        ];

        $data = [
            "kendaraan" => Kendaraan::where("isShow", 1)->where("isReady", 1)->count(),
            "driver" => Driver::where("isShow", 1)->where("isReady", 1)->count(),
            "status_peminjaman" => Peminjaman::where("user_id", Auth::user()->id)->where("status", "!=", "selesai")->pluck("status")->first(),
            "status_reimburse" => Reimbursement::where('user_id', Auth::user()->id)->where('status', '!=', 'selesai')->first(),

            "kendaraan_terpakai" => Kendaraan::where("isShow", 1)->where("isReady", 0)->count(),
            "driver_terpakai" => Driver::where("isShow", 1)->where("isReady", 0)->count(),
            "konfirmasi_reimburse" => Reimbursement::where('status', "Dalam proses pengajuan")->get()->count(),
        ];

        $reimburse = [
            'total' => Reimbursement::where('user_id', Auth::user()->id)->whereMonth("created_at", date("m"))->get()->count(),
            'diterima' => Reimbursement::where('user_id', Auth::user()->id)->whereMonth("created_at", date("m"))->where('status', 'Pengajuan disetujui')->get()->count(),
            'ditolak' => Reimbursement::where('user_id', Auth::user()->id)->whereMonth("created_at", date("m"))->where('status', 'Pengajuan ditolak')->get()->count(),
        ];

        return view("dashboard", compact('peminjaman', 'antrian', 'data', 'reimburse', 'notifikasi'));
    }
}
