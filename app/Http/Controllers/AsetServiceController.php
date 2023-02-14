<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AsetServiceController extends Controller
{
    public function data()
    {
        return view('master-data.asset-service-data');
    }

    public function rekap()
    {
        return view('master-data.asset-service-rekap');
    }
}
