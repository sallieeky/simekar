<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AssetController extends Controller
{
    public function data()
    {
        return view('master-data.asset-data');
    }
    public function rekap()
    {
        return view('master-data.asset-rekap');
    }
}