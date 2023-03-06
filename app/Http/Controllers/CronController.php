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
}
