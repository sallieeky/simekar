<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PeminjamanController extends Controller
{
    public function pengajuan()
    {
        return view('peminjaman.pengajuan');
    }

    public function riwayat()
    {
        return view('peminjaman.riwayat');
    }
}
