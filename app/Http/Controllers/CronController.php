<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use App\Models\Kendaraan;
use App\Models\Peminjaman;
use Carbon\Carbon;

class CronController extends Controller
{
    public function daily()
    {
        $this->reminderPajakKendaraan_Hmin14_Admin();
        $this->reminderPajakStnk_Hmin14_Admin();
        $this->reminderPajakAsuransi_Hmin14_Admin();
        $this->reminderPajakKendaraan_Hplus3_Admin();
        $this->reminderPajakStnk_Hplus3_Admin();
        $this->reminderPajakAsuransi_Hplus3_Admin();
        $this->reminderServiceRutinKendaraan_Admin();
        $this->cekPeminjaman_H_user();
    }

    private function cekPeminjaman_H_user()
    {
        $peminjaman = Peminjaman::where('status', 'menunggu')
            ->whereDate('waktu_peminjaman', Carbon::now()->format('Y-m-d'))
            ->get();

        $kendaraan = Kendaraan::where('isReady', 1)->inRandomOrder()->get();
        $driver = Driver::where('isReady', 1)->inRandomOrder()->get();

        if ($peminjaman->count() > 0 && $kendaraan && $driver) {
            $i = 0;
            foreach ($peminjaman as $p) {
                if ($i == $kendaraan->count() || $i == $driver->count()) {
                    break;
                }
                $p->kendaraan_id = $kendaraan[$i]->id;
                $p->driver_id = $driver[$i]->id;
                $p->status = 'dipakai';
                $p->save();

                $kendaraan[$i]->isReady = 0;
                $kendaraan[$i]->save();

                $driver[$i]->isReady = 0;
                $driver[$i]->save();

                $i++;

                // data nama pegawai, nama driver, no polisi, merk, tipe, waktu peminjaman, waktu selesai, tujuan, alamat, keperluan
                $dataWA = [
                    "nama_pegawai" => $p->user->nama,
                    "nohp_pegawai" => $p->user->no_hp,
                    "nama_driver" => $p->driver->nama ?? null,
                    "nohp_driver" => $p->driver->no_hp ?? null,
                    "no_polisi" => $p->kendaraan->no_polisi ?? null,
                    "merk" => $p->kendaraan->merk ?? null,
                    "tipe" => $p->kendaraan->tipe ?? null,
                    "waktu_peminjaman" => $p->waktu_peminjaman,
                    "waktu_selesai" => $p->waktu_selesai,
                    "tujuan" => $p->tujuan_peminjaman->nama,
                    "alamat" => $p->tujuan_peminjaman->alamat,
                    "keperluan" => $p->keperluan,
                ];

                WhatsApp::mendapatkanKendaraanSetelahMenungguPadaAntrian_Admin($dataWA);
                WhatsApp::mendapatkanKendaraanSetelahMenungguPadaAntrian_Driver($dataWA);
                WhatsApp::mendapatkanKendaraanSetelahMenungguPadaAntrian_User($dataWA);
            }
        }
    }

    private function reminderPajakKendaraan_Hmin14_Admin()
    {
        $kendaraan = Kendaraan::whereHas('asetKendaraan', function ($query) {
            $query->whereDate('masa_pajak', Carbon::now()->addDays(14));
        })->get();

        if ($kendaraan->count() > 0) {
            foreach ($kendaraan as $k) {
                $dataWa = [
                    "merk" => $k->merk,
                    "tipe" => $k->tipe,
                    "no_polisi" => $k->no_polisi,
                    "masa_pajak" => Carbon::parse($k->asetKendaraan->masa_pajak)->translatedFormat('l, d F Y'),
                ];
                WhatsApp::reminderPajakKendaraan_Hmin14_Admin($dataWa);
            }
        }
    }

    private function reminderPajakStnk_Hmin14_Admin()
    {
        $kendaraan = Kendaraan::whereHas('asetKendaraan', function ($query) {
            $query->whereDate('masa_stnk', Carbon::now()->addDays(14));
        })->get();

        if ($kendaraan->count() > 0) {
            foreach ($kendaraan as $k) {
                $dataWa = [
                    "merk" => $k->merk,
                    "tipe" => $k->tipe,
                    "no_polisi" => $k->no_polisi,
                    "masa_pajak" => Carbon::parse($k->asetKendaraan->masa_stnk)->translatedFormat('l, d F Y'),
                ];
                WhatsApp::reminderPajakStnk_Hmin14_Admin($dataWa);
            }
        }
    }

    private function reminderPajakAsuransi_Hmin14_Admin()
    {
        $kendaraan = Kendaraan::whereHas('asetKendaraan', function ($query) {
            $query->whereDate('masa_asuransi', Carbon::now()->addDays(14));
        })->get();

        if ($kendaraan->count() > 0) {
            foreach ($kendaraan as $k) {
                $dataWa = [
                    "merk" => $k->merk,
                    "tipe" => $k->tipe,
                    "no_polisi" => $k->no_polisi,
                    "masa_pajak" => Carbon::parse($k->asetKendaraan->masa_asuransi)->translatedFormat('l, d F Y'),
                ];
                WhatsApp::reminderPajakAsuransi_Hmin14_Admin($dataWa);
            }
        }
    }

    private function reminderPajakKendaraan_Hplus3_Admin()
    {
        $kendaraan = Kendaraan::whereHas('asetKendaraan', function ($query) {
            $query->whereDate('masa_pajak', Carbon::now()->subDays(3));
        })->get();

        if ($kendaraan->count() > 0) {
            foreach ($kendaraan as $k) {
                $dataWa = [
                    "merk" => $k->merk,
                    "tipe" => $k->tipe,
                    "no_polisi" => $k->no_polisi,
                    "masa_pajak" => Carbon::parse($k->asetKendaraan->masa_pajak)->translatedFormat('l, d F Y'),
                ];
                WhatsApp::reminderPajakKendaraan_Hplus3_Admin($dataWa);
            }
        }
    }

    private function reminderPajakStnk_Hplus3_Admin()
    {
        $kendaraan = Kendaraan::whereHas('asetKendaraan', function ($query) {
            $query->whereDate('masa_stnk', Carbon::now()->subDays(3));
        })->get();

        if ($kendaraan->count() > 0) {
            foreach ($kendaraan as $k) {
                $dataWa = [
                    "merk" => $k->merk,
                    "tipe" => $k->tipe,
                    "no_polisi" => $k->no_polisi,
                    "masa_pajak" => Carbon::parse($k->asetKendaraan->masa_stnk)->translatedFormat('l, d F Y'),
                ];
                WhatsApp::reminderPajakStnk_Hplus3_Admin($dataWa);
            }
        }
    }

    private function reminderPajakAsuransi_Hplus3_Admin()
    {
        $kendaraan = Kendaraan::whereHas('asetKendaraan', function ($query) {
            $query->whereDate('masa_asuransi', Carbon::now()->subDays(3));
        })->get();

        if ($kendaraan->count() > 0) {
            foreach ($kendaraan as $k) {
                $dataWa = [
                    "merk" => $k->merk,
                    "tipe" => $k->tipe,
                    "no_polisi" => $k->no_polisi,
                    "masa_pajak" => Carbon::parse($k->asetKendaraan->masa_asuransi)->translatedFormat('l, d F Y'),
                ];
                WhatsApp::reminderPajakAsuransi_Hplus3_Admin($dataWa);
            }
        }
    }

    private function reminderServiceRutinKendaraan_Admin()
    {
        $kendaraan = Kendaraan::whereHas('asetKendaraan', function ($query) {
            $query->whereDate('tgl_service_rutin', Carbon::now());
        })->get();

        if ($kendaraan->count() > 0) {
            foreach ($kendaraan as $k) {
                $dataWa = [
                    "merk" => $k->merk,
                    "tipe" => $k->tipe,
                    "no_polisi" => $k->no_polisi,
                    "tgl_service_terakhir" => Carbon::parse($k->asetKendaraan->tgl_service_rutin)->translatedFormat('l, d F Y'),
                ];
                WhatsApp::reminderServiceRutinKendaraan_Admin($dataWa);
            }
        }
    }
}
