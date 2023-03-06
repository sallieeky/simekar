<?php

namespace App\Http\Controllers;

use App\Models\Kendaraan;
use Carbon\Carbon;
use Illuminate\Http\Request;

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
