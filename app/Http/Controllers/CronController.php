<?php

namespace App\Http\Controllers;

use App\Models\Kendaraan;
use Illuminate\Http\Request;

class CronController extends Controller
{
    public function tes()
    {
        $data = Kendaraan::all();
        WhatsApp::reminderPajakKendaraan_Hmin14_Admin($data);
    }
}
