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
            $data = Peminjaman::where('status', '!=', 'selesai')->whereDate('created_at', date('Y-m-d'))->get();
            return view('peminjaman.admin.pengajuan', compact('data'));
        }
    }

    public function pengajuanCek(Request $request)
    {
        // cek apakah ada driver dan kendaraan yang tersedia dan pilih satu secara random
        $driver = Driver::where('isShow', 1)->where('isReady', 1)->inRandomOrder()->first();
        $kendaraan = Kendaraan::where('isShow', 1)->where('isReady', 1)->inRandomOrder()->first();

        // cek apakah user sudah pernah melakukan peminjaman where status dipakai dan menunggu
        $peminjaman = Peminjaman::where('user_id', Auth::user()->id)->where('status', '!=', 'selesai')->first();

        // jika user sudah pernah melakukan peminjaman
        if ($peminjaman) {
            return response()->json([
                'status' => 'exist',
                'message' => 'Peminjaman ditolak',
            ]);
        } else {
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
    }

    public function pengajuanPost(Request $request)
    {
        $request->validate([
            'nama_tujuan' => 'required',
            'keperluan' => 'required',
            'tanggal_peminjaman' => 'required',
            'waktu_peminjaman' => 'required|date_format:H:i|after_or_equal:' . date('H:i', strtotime('-5 minutes')) . '|before:17:00',
            'waktu_selesai' => 'required|after_or_equal:' . date('Y-m-d H:i'),
        ], [
            'nama_tujuan.required' => 'Nama tujuan tidak boleh kosong',
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
            'nama' => $request->nama_tujuan,
            'alamat' => $request->alamat_tujuan,
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

        // cek nomor peminjaman hari ini
        $nomorPeminjaman = Peminjaman::whereDate('created_at', date('Y-m-d'))->count() + 1;

        Peminjaman::create([
            'user_id' => Auth::user()->id,
            'driver_id' => $request->driver_id,
            'kendaraan_id' => $request->kendaraan_id,
            'tujuan_peminjaman_id' => $tujuanPeminjaman->id,
            'nomor_peminjaman' => $nomorPeminjaman,
            'keperluan' => $request->keperluan,
            'status' => $status,
            'waktu_peminjaman' => $request->tanggal_peminjaman . ' ' . $request->waktu_peminjaman,
            'waktu_selesai' => $request->waktu_selesai,
        ]);

        if ($status == 'menunggu') {
            $pesan = "Anda sedang dalam antrian, silahkan menunggu!";
        } else {
            $pesan = "Peminjaman berhasil";
        }

        return back()->with('success', $pesan);
    }

    public function riwayat()
    {
        $data = Peminjaman::with('driver', 'kendaraan', 'tujuan_peminjaman', 'user')->where('user_id', Auth::user()->id)->orderBy('created_at', 'asc')->get();
        return view('peminjaman.user.riwayat', compact('data'));
    }

    public function riwayatNota(Request $request, $aksi)
    {
        $pdf = app('dompdf.wrapper');
        $peminjaman = Peminjaman::where('id', $request->id)->first();

        $pdf->loadView('pdf.nota-riwayat', compact('peminjaman'));

        // cek aksi
        if ($aksi == "unduh") {
            $namaFile = "nota-peminjaman-" . date('Y-m-d') . ".pdf";
            return $pdf->download($namaFile);
        } else if ($aksi == "lihat") {
            return $pdf->stream();
        }
    }

    public function selesai(Peminjaman $peminjaman)
    {
        if (Auth::user()->role == "user") {
            if ($peminjaman->user_id == Auth::user()->id) {
                $peminjaman->status = "selesai";
                $peminjaman->save();

                // cek peminjaman status menunggu
                $peminjamanMenunggu = Peminjaman::where("status", "menunggu")->orderBy('waktu_peminjaman', 'asc')->first();
                if ($peminjamanMenunggu) {
                    $peminjamanMenunggu->driver_id = $peminjaman->driver_id;
                    $peminjamanMenunggu->kendaraan_id = $peminjaman->kendaraan_id;
                    $peminjamanMenunggu->status = "dipakai";
                    $peminjamanMenunggu->save();
                } else {
                    // update isReady driver dan kendaraan menjadi true
                    Driver::where("id", $peminjaman->driver_id)->update(["isReady" => true]);
                    Kendaraan::where("id", $peminjaman->kendaraan_id)->update(["isReady" => true]);
                }
                return redirect()->back()->with('success', 'Peminjaman berhasil di selesaikan');
            }
        } else if (Auth::user()->role == "admin") {
            $peminjaman->status = "selesai";
            $peminjaman->save();

            // cek peminjaman status menunggu
            $peminjamanMenunggu = Peminjaman::where("status", "menunggu")->orderBy('waktu_peminjaman', 'asc')->first();
            if ($peminjamanMenunggu) {
                $peminjamanMenunggu->driver_id = $peminjaman->driver_id;
                $peminjamanMenunggu->kendaraan_id = $peminjaman->kendaraan_id;
                $peminjamanMenunggu->status = "dipakai";
                $peminjamanMenunggu->save();
            } else {
                // update isReady driver dan kendaraan menjadi true
                Driver::where("id", $peminjaman->driver_id)->update(["isReady" => true]);
                Kendaraan::where("id", $peminjaman->kendaraan_id)->update(["isReady" => true]);
            }
            return redirect()->back()->with('success', 'Peminjaman berhasil di selesaikan');
        }
    }

    public function batal(Peminjaman $peminjaman)
    {
        if (Auth::user()->role == "user" && $peminjaman->user_id == Auth::user()->id) {
            $peminjaman->delete();
        } else if (Auth::user()->role == "admin") {
            $peminjaman->delete();
        }

        return redirect()->back()->with('success', 'Peminjaman berhasil di batalkan');
    }

    public function rekap()
    {
        // get data peminjaman semua
        $data = Peminjaman::with('driver', 'kendaraan', 'tujuan_peminjaman', 'user')->where("status", "selesai")->orderBy('created_at', 'asc')->get();
        return view('peminjaman.admin.rekap', compact('data'));
    }
}
