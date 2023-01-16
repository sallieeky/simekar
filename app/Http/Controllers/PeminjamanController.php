<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use App\Models\Kendaraan;
use App\Models\Peminjaman;
use App\Models\TujuanPeminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PeminjamanController extends Controller
{
    public function pengajuan()
    {
        if (Auth::user()->role == 'user') {
            return view('peminjaman.user.pengajuan');
        } else {
            // 
        }
    }

    public function pengajuanCek(Request $request)
    {
        // cek apakah ada driver dan kendaraan yang tersedia dan pilih satu secara random
        $driver = Driver::where('isShow', 1)->where('isReady', 1)->inRandomOrder()->first();
        $kendaraan = Kendaraan::where('isShow', 1)->where('isReady', 1)->inRandomOrder()->first();

        // jika ada driver dan kendaraan yang tersedia
        if ($driver && $kendaraan) {
            return response()->json([
                'status' => 'success',
                'message' => 'Driver dan kendaraan tersedia',
                'driver' => $driver,
                'kendaraan' => $kendaraan,
            ]);
        } else if (!$driver && $kendaraan) {
            return response()->json([
                'status' => 'error',
                'message' => 'Driver tidak tersedia',
            ]);
        } else if ($driver && !$kendaraan) {
            return response()->json([
                'status' => 'error',
                'message' => 'Kendaraan tidak tersedia',
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Driver dan kendaraan tidak tersedia',
            ]);
        }
    }

    public function pengajuanPost(Request $request)
    {
        $request->validate([
            // 'latitude' => 'required',
            // 'longitude' => 'required',
            'keperluan' => 'required',
            'tanggal_peminjaman' => 'required',
            'waktu_peminjaman' => 'required|date_format:H:i|after_or_equal:' . date('H:i') . '|before:17:00',
            'waktu_selesai' => 'required|after_or_equal:' . date('Y-m-d H:i'),
        ], [
            // 'latitude.required' => 'Lokasi tidak boleh kosong',
            // 'longitude.required' => 'Lokasi tidak boleh kosong',
            'keperluan.required' => 'Keperluan tidak boleh kosong',
            'tanggal_peminjaman.required' => 'Tanggal peminjaman tidak boleh kosong',
            'waktu_peminjaman.required' => 'Waktu peminjaman tidak boleh kosong',
            'waktu_peminjaman.after_or_equal' => 'Waktu peminjaman tidak boleh kurang dari jam sekarang',
            'waktu_peminjaman.before' => 'Waktu peminjaman tidak boleh lebih dari jam 16:59',
            'waktu_selesai.required' => 'Waktu selesai tidak boleh kosong',
            'waktu_selesai.date_format' => 'Format waktu selesai tidak valid',
            'waktu_selesai.after_or_equal' => 'Waktu selesai tidak boleh kurang dari tanggal dan jam sekarang',
        ]);

        $tujuanPeminjaman = TujuanPeminjaman::create([
            'nama' => "Institut Teknologi Kalimantan",
            'alamat' => "Jl. Soekarno Hatta No. 1, Samarinda, Kalimantan Timur, Indonesia",
            'latitude' => "0.500000",
            'longitude' => "117.150000",
        ]);

        if ($request->driver_id != null || $request->kendaraan_id != null) {
            $driver = Driver::find($request->driver_id);
            $kendaraan = Kendaraan::find($request->kendaraan_id);

            $driver->isReady = 0;
            $kendaraan->isReady = 0;

            $driver->save();
            $kendaraan->save();
        }

        $status = ($request->driver_id == null || $request->kendaraan_id == null) ? 'menunggu' : 'dipakai';

        Peminjaman::create([
            'user_id' => Auth::user()->id,
            'driver_id' => $request->driver_id,
            'kendaraan_id' => $request->kendaraan_id,
            'tujuan_peminjaman_id' => $tujuanPeminjaman->id,
            'keperluan' => $request->keperluan,
            'status' => $status,
            'waktu_peminjaman' => $request->tanggal_peminjaman . ' ' . $request->waktu_peminjaman,
            'waktu_selesai' => $request->waktu_selesai,
        ]);

        return back()->with('success', 'Pengajuan peminjaman berhasil dikirim');
    }

    public function riwayat()
    {
        return view('peminjaman.user.riwayat');
    }
}
