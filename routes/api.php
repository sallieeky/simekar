<?php

use App\Models\AsetKendaraan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get("/calendar", function (Request $request) {
    $timestart = date("Y-m-d", $request->timestart / 1000);
    $timeend = date("Y-m-d", $request->timeend / 1000);

    $aset = AsetKendaraan::with("kendaraan")->whereBetween($request->category, [$timestart, $timeend])->get();
    return response()->json($aset);
});
