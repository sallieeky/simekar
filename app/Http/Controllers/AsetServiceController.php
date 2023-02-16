<?php

namespace App\Http\Controllers;

use App\Models\AsetKendaraan;
use App\Models\Kendaraan;
use App\Models\ServiceKendaraan;
use Illuminate\Http\Request;

class AsetServiceController extends Controller
{
    public function data()
    {
        $kendaraan = Kendaraan::doesntHave('asetKendaraan')->get();
        $kendaraanService = Kendaraan::all();

        $kodeService = [
            [
                'code' => 'SR',
                'keterangan' => 'Service Rutin'
            ],
            [
                'code' => 'SB',
                'keterangan' => 'Service Berat'
            ],
            [
                'code' => 'SPB',
                'keterangan' => 'Sparepart Biasa'
            ],
            [
                'code' => 'SPM',
                'keterangan' => 'Sparepart Mesin'
            ],
            [
                'code' => 'ACC',
                'keterangan' => 'Aksesoris'
            ]
        ];
        return view('master-data.asset-service-data', compact('kendaraan', 'kendaraanService', 'kodeService'));
    }

    public function tambahAset(Request $request)
    {
        $request->validate([
            'kendaraan_id' => 'required',
            'no_aset' => 'required',
            'no_polis' => 'required',
            'no_rangka' => 'required|digits:17',
            'no_mesin' => 'required',
            'masa_pajak' => 'required',
            'masa_stnk' => 'required',
            'masa_asuransi' => 'required',
            'tgl_service_rutin' => 'required',
            'tahun_pembuatan' => 'required|digits:4|lte:' . date('Y'),
            'tahun_pengadaan' => 'required|digits:4|min:1700|lte:' . date('Y'),
        ], [
            'kendaraan_id.required' => 'Kendaraan harus dipilih',
            'no_aset.required' => 'No. Aset harus diisi',
            'no_polis.required' => 'No. Polis harus diisi',
            'no_rangka.required' => 'No. Rangka harus diisi',
            'no_rangka.digits' => 'No. Rangka harus 17 digit',
            'no_mesin.required' => 'No. Mesin harus diisi',
            'masa_pajak.required' => 'Masa Pajak harus diisi',
            'masa_stnk.required' => 'Masa STNK harus diisi',
            'masa_asuransi.required' => 'Masa Asuransi harus diisi',
            'tgl_service_rutin.required' => 'Tanggal Service Rutin harus diisi',
            'tahun_pembuatan.required' => 'Tahun Pembuatan harus diisi',
            'tahun_pembuatan.digits' => 'Tahun Pembuatan harus 4 digit',
            'tahun_pembuatan.min' => 'Tahun Pembuatan tidak valid',
            'tahun_pembuatan.lte' => 'Tahun Pembuatan tidak valid',
            'tahun_pengadaan.required' => 'Tahun Pengadaan harus diisi',
            'tahun_pengadaan.digits' => 'Tahun Pengadaan harus 4 digit',
            'tahun_pengadaan.min' => 'Tahun Pengadaan tidak valid',
            'tahun_pengadaan.lte' => 'Tahun Pengadaan tidak valid',
        ]);

        AsetKendaraan::create($request->all());

        return redirect()->back()->with('success', 'Data berhasil ditambahkan');
    }

    public function tambahService(Request $request)
    {
        $request->validate([
            'kendaraan_id_service' => 'required',
            'kode' => 'required',
            'uraian' => 'required',
            'tgl_service' => 'required|date|before_or_equal:' . date('Y-m-d'),
        ], [
            'kendaraan_id_service.required' => 'Kendaraan harus dipilih',
            'kode.required' => 'Kode harus dipilih',
            'uraian.required' => 'Uraian harus diisi',
            'tgl_service.required' => 'Tanggal Service harus diisi',
            'tgl_service.date' => 'Tanggal Service tidak valid',
            'tgl_service.before_or_equal' => 'Tanggal Service tidak valid',
        ]);

        $request->merge([
            'kendaraan_id' => $request->kendaraan_id_service
        ]);
        ServiceKendaraan::create($request->all());

        return redirect()->back()->with('success', 'Data berhasil ditambahkan');
    }

    public function rekap()
    {
        return view('master-data.asset-service-rekap');
    }
}
