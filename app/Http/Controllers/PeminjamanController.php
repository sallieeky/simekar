<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use App\Models\Kendaraan;
use App\Models\Peminjaman;
use App\Models\TujuanPeminjaman;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

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
        $driver = Driver::where('isShow', 1)->where('isReady', 1)->inRandomOrder()->first();
        $kendaraan = Kendaraan::where('isShow', 1)->where('isReady', 1)->inRandomOrder()->first();
        $peminjaman = Peminjaman::where('user_id', Auth::user()->id)->where('status', '!=', 'selesai')->first();

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
                    'status' => 'no_driver',
                    'message' => 'Driver tidak tersedia',
                    'kendaraan' => $kendaraan,
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
            if ($request->driver_id != 0) {
                $driver = Driver::find($request->driver_id);
                $driver->isReady = 0;
                $driver->save();
            }
            $kendaraan = Kendaraan::find($request->kendaraan_id);
            $kendaraan->isReady = 0;

            $kendaraan->save();
        }

        $status = ($request->driver_id == null || $request->kendaraan_id == null) ? 'menunggu' : 'dipakai';

        $nomorPeminjaman = Peminjaman::whereMonth('created_at', Carbon::now()->month)->get()->count() + 1;
        $dtPeminjaman = Peminjaman::create([
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

        $dataWA = [
            "nama_pegawai" => $dtPeminjaman->user->nama,
            "nohp_pegawai" => $dtPeminjaman->user->no_hp,
            "nama_driver" => $dtPeminjaman->driver->nama ?? null,
            "nohp_driver" => $dtPeminjaman->driver->no_hp ?? null,
            "no_polisi" => $dtPeminjaman->kendaraan->no_polisi ?? null,
            "merk" => $dtPeminjaman->kendaraan->merk ?? null,
            "tipe" => $dtPeminjaman->kendaraan->tipe ?? null,
            "waktu_peminjaman" => $dtPeminjaman->waktu_peminjaman,
            "waktu_selesai" => $dtPeminjaman->waktu_selesai,
            "tujuan" => $dtPeminjaman->tujuan_peminjaman->nama,
            "alamat" => $dtPeminjaman->tujuan_peminjaman->alamat,
            "keperluan" => $dtPeminjaman->keperluan,
        ];

        if (isset($dtPeminjaman->driver->nama)) {
            WhatsApp::peminjamanBerhasilKendaraanDriver_Admin($dataWA);
            WhatsApp::peminjamanBerhasilKendaraanDriver_Driver($dataWA);
            WhatsApp::peminjamanBerhasilKendaraanDriver_User($dataWA);
        } else if (isset($dtPeminjaman->kendaraan->no_polisi) && !isset($dtPeminjaman->driver->nama)) {
            WhatsApp::peminjamanBerhasilKendaraan_Admin($dataWA);
            WhatsApp::peminjamanBerhasilKendaraan_User($dataWA);
        } else {
            WhatsApp::masukAntrianKendaraan_Admin($dataWA);
            WhatsApp::masukAntrianKendaraan_User($dataWA);
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

        $pdf->loadView('pdf.nota-riwayat-peminjaman', compact('peminjaman'));

        if ($aksi == "unduh") {
            $namaFile = "nota-peminjaman-" . date('Y-m-d') . ".pdf";
            return $pdf->download($namaFile);
        } else if ($aksi == "lihat") {
            return $pdf->stream();
        }
    }

    public function selesai(Peminjaman $peminjaman)
    {
        $kendaraan = Kendaraan::where('isShow', 1)->where('isReady', 1)->inRandomOrder()->first();
        $driver = Driver::where('isShow', 1)->where('isReady', 1)->inRandomOrder()->first();
        if (Auth::user()->role == "user") {
            if ($peminjaman->user_id == Auth::user()->id) {
                $peminjaman->status = "selesai";
                $peminjaman->save();

                $peminjamanMenunggu = Peminjaman::where("status", "menunggu")->orderBy('waktu_peminjaman', 'asc')->first();
                if ($peminjamanMenunggu) {
                    $peminjamanMenunggu->driver_id = $driver ? $driver->id : $peminjaman->driver->id;
                    $peminjamanMenunggu->kendaraan_id = $kendaraan ? $kendaraan->id : $peminjaman->kendaraan->id;
                    $peminjamanMenunggu->status = "dipakai";
                    $peminjamanMenunggu->save();

                    $dataWA = [
                        "nama_pegawai" => $peminjamanMenunggu->user->nama,
                        "nohp_pegawai" => $peminjamanMenunggu->user->no_hp,
                        "nama_driver" => $peminjamanMenunggu->driver->nama ?? null,
                        "nohp_driver" => $peminjamanMenunggu->driver->no_hp ?? null,
                        "no_polisi" => $peminjamanMenunggu->kendaraan->no_polisi ?? null,
                        "merk" => $peminjamanMenunggu->kendaraan->merk ?? null,
                        "tipe" => $peminjamanMenunggu->kendaraan->tipe ?? null,
                        "waktu_peminjaman" => $peminjamanMenunggu->waktu_peminjaman,
                        "waktu_selesai" => $peminjamanMenunggu->waktu_selesai,
                        "tujuan" => $peminjamanMenunggu->tujuan_peminjaman->nama,
                        "alamat" => $peminjamanMenunggu->tujuan_peminjaman->alamat,
                        "keperluan" => $peminjamanMenunggu->keperluan,
                    ];

                    WhatsApp::mendapatkanKendaraanSetelahMenungguPadaAntrian_Admin($dataWA);
                    WhatsApp::mendapatkanKendaraanSetelahMenungguPadaAntrian_Driver($dataWA);
                    WhatsApp::mendapatkanKendaraanSetelahMenungguPadaAntrian_User($dataWA);
                } else {
                    Driver::where("id", $peminjaman->driver_id)->update(["isReady" => true]);
                    Kendaraan::where("id", $peminjaman->kendaraan_id)->update(["isReady" => true]);


                    $dataWA = [
                        "nama_pegawai" => $peminjaman->user->nama,
                        "nohp_pegawai" => $peminjaman->user->no_hp,
                        "nama_driver" => $peminjaman->driver->nama ?? null,
                        "nohp_driver" => $peminjaman->driver->no_hp ?? null,
                        "no_polisi" => $peminjaman->kendaraan->no_polisi ?? null,
                        "merk" => $peminjaman->kendaraan->merk ?? null,
                        "tipe" => $peminjaman->kendaraan->tipe ?? null,
                        "waktu_peminjaman" => $peminjaman->waktu_peminjaman,
                        "waktu_selesai" => $peminjaman->waktu_selesai,
                        "tujuan" => $peminjaman->tujuan_peminjaman->nama,
                        "alamat" => $peminjaman->tujuan_peminjaman->alamat,
                        "keperluan" => $peminjaman->keperluan,
                    ];
                    WhatsApp::melakukanKonfirmasiSelesaiPeminjaman_Admin($dataWA);
                    WhatsApp::melakukanKonfirmasiSelesaiPeminjaman_Driver($dataWA);
                    WhatsApp::melakukanKonfirmasiSelesaiPeminjaman_User($dataWA);
                }
                return redirect()->back()->with('success', 'Peminjaman berhasil di selesaikan');
            }
        } else if (Auth::user()->role == "admin") {
            $peminjaman->status = "selesai";
            $peminjaman->save();

            $peminjamanMenunggu = Peminjaman::where("status", "menunggu")->orderBy('waktu_peminjaman', 'asc')->first();
            if ($peminjamanMenunggu) {
                $peminjamanMenunggu->driver_id = $driver ? $driver->id : $peminjaman->driver->id;
                $peminjamanMenunggu->kendaraan_id = $kendaraan ? $kendaraan->id : $peminjaman->kendaraan->id;
                $peminjamanMenunggu->status = "dipakai";
                $peminjamanMenunggu = $peminjamanMenunggu->save();

                $dataWA = [
                    "nama_pegawai" => $peminjamanMenunggu->user->nama,
                    "nohp_pegawai" => $peminjamanMenunggu->user->no_hp,
                    "nama_driver" => $peminjamanMenunggu->driver->nama ?? null,
                    "nohp_driver" => $peminjamanMenunggu->driver->no_hp ?? null,
                    "no_polisi" => $peminjamanMenunggu->kendaraan->no_polisi ?? null,
                    "merk" => $peminjamanMenunggu->kendaraan->merk ?? null,
                    "tipe" => $peminjamanMenunggu->kendaraan->tipe ?? null,
                    "waktu_peminjaman" => $peminjamanMenunggu->waktu_peminjaman,
                    "waktu_selesai" => $peminjamanMenunggu->waktu_selesai,
                    "tujuan" => $peminjamanMenunggu->tujuan_peminjaman->nama,
                    "alamat" => $peminjamanMenunggu->tujuan_peminjaman->alamat,
                    "keperluan" => $peminjamanMenunggu->keperluan,
                ];

                WhatsApp::mendapatkanKendaraanSetelahMenungguPadaAntrian_Admin($dataWA);
                WhatsApp::mendapatkanKendaraanSetelahMenungguPadaAntrian_Driver($dataWA);
                WhatsApp::mendapatkanKendaraanSetelahMenungguPadaAntrian_User($dataWA);
            } else {
                Driver::where("id", $peminjaman->driver_id)->update(["isReady" => true]);
                Kendaraan::where("id", $peminjaman->kendaraan_id)->update(["isReady" => true]);

                $dataWA = [
                    "nama_pegawai" => $peminjaman->user->nama,
                    "nohp_pegawai" => $peminjaman->user->no_hp,
                    "nama_driver" => $peminjaman->driver->nama ?? null,
                    "nohp_driver" => $peminjaman->driver->no_hp ?? null,
                    "no_polisi" => $peminjaman->kendaraan->no_polisi ?? null,
                    "merk" => $peminjaman->kendaraan->merk ?? null,
                    "tipe" => $peminjaman->kendaraan->tipe ?? null,
                    "waktu_peminjaman" => $peminjaman->waktu_peminjaman,
                    "waktu_selesai" => $peminjaman->waktu_selesai,
                    "tujuan" => $peminjaman->tujuan_peminjaman->nama,
                    "alamat" => $peminjaman->tujuan_peminjaman->alamat,
                    "keperluan" => $peminjaman->keperluan,
                ];
                WhatsApp::melakukanKonfirmasiSelesaiPeminjamanAdmin_Admin($dataWA);
                WhatsApp::melakukanKonfirmasiSelesaiPeminjamanAdmin_Driver($dataWA);
                WhatsApp::melakukanKonfirmasiSelesaiPeminjamanAdmin_User($dataWA);
            }
            return redirect()->back()->with('success', 'Peminjaman berhasil di selesaikan');
        }
    }

    public function batal(Peminjaman $peminjaman)
    {
        $dataWA = [
            "nama_pegawai" => $peminjaman->user->nama,
            "nohp_pegawai" => $peminjaman->user->no_hp,
        ];
        if (Auth::user()->role == "user" && $peminjaman->user_id == Auth::user()->id) {
            WhatsApp::melakukanPembatalanPeminjamanDiAntrianKendaraan_Admin($dataWA);
            WhatsApp::melakukanPembatalanPeminjamanDiAntrianKendaraan_User($dataWA);
            $peminjaman->delete();
        } else if (Auth::user()->role == "admin") {
            WhatsApp::melakukanPembatalanPeminjamanDiAntrianKendaraanAdmin_Admin($dataWA);
            WhatsApp::melakukanPembatalanPeminjamanDiAntrianKendaraanAdmin_User($dataWA);
            $peminjaman->delete();
        }

        return redirect()->back()->with('success', 'Peminjaman berhasil di batalkan');
    }

    public function rekap()
    {
        $data = Peminjaman::with('driver', 'kendaraan', 'tujuan_peminjaman', 'user')
            ->where("status", "selesai")
            ->orderBy('waktu_peminjaman', 'asc')
            ->get();
        return view('peminjaman.admin.rekap', compact('data'));
    }

    public function rekapExport(Request $request)
    {
        $data = Peminjaman::with('driver', 'kendaraan', 'tujuan_peminjaman', 'user')
            ->whereDate('created_at', '>=', $request->tanggal_dari)
            ->whereDate('created_at', '<=', $request->tanggal_sampai)
            ->where("status", "selesai")
            ->orderBy('created_at', 'asc')
            ->get();

        if ($data->count() == 0) {
            return false;
        }

        $filename = "rekap-peminjaman-" . date('Y-m-d') . ".csv";
        $handle = fopen($filename, 'w+');

        fputcsv($handle, array('Tanggal Dari', $request->tanggal_dari), ';');
        fputcsv($handle, array('Tanggal Sampai', $request->tanggal_sampai), ';');

        fputcsv($handle, array('Nomor', 'Nomor Nota', 'Nama Karyawan', 'Nomor Telepon', 'Nomor Polisi', 'Merk Kendaraan', 'Tipe Kendaraan', 'Nama Driver', 'Tanggal Peminjaman', 'Estimasi Selesai', 'Nama Tujuan', 'Alamat Tujuan', 'Keperluan'), ';');

        $no = 1;
        foreach ($data as $row) {
            $nomor_peminjaman = $row->nomor_peminjaman;
            if ($nomor_peminjaman < 10) {
                $nomor_peminjaman = '00' . $nomor_peminjaman;
            } elseif ($nomor_peminjaman < 100) {
                $nomor_peminjaman = '0' . $nomor_peminjaman;
            }
            $ns = "UMUM/PKR/$nomor_peminjaman/" . date('m', strtotime($row->created_at)) . "/" . date('Y', strtotime($row->created_at));
            fputcsv($handle, array($no, $ns, $row->user->nama, $row->user->no_hp, $row->kendaraan->no_polisi, $row->kendaraan->merk, $row->kendaraan->tipe, $row->driver_id != 0 ? $row->driver->nama : "Tanpa Driver", $row->waktu_peminjaman, $row->waktu_selesai, $row->tujuan_peminjaman->nama, $row->tujuan_peminjaman->alamat, $row->keperluan), ';');
            $no++;
        }
        fclose($handle);
        $headers = array(
            'Content-Type' => 'text/csv',
        );

        return Response::download($filename, $filename, $headers)->deleteFileAfterSend(true);
    }
}
