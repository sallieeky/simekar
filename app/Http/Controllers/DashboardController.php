<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $peminjaman = Peminjaman::where('user_id', Auth::user()->id)->where('status', '!=', 'selesai')->first();
        $antrian = Peminjaman::where('status', 'menunggu')->orderBy('created_at', 'asc')->get();

        return view("dashboard", compact('peminjaman', 'antrian'));
    }
}
