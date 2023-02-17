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

    public function getAset(AsetKendaraan $aset)
    {
        $kendaraan = Kendaraan::doesntHave('asetKendaraan')->get();
        $html = "
        <input type='hidden' name='id' value='$aset->id'>
        <div class='row'>
        <div class='col-md-12 mb-3'>
          <label for='kendaraan_id'>Kendaraan</label>
          <select class='form-select' name='kendaraan_id' id='kendaraan_id'>
          <option value='" . $aset->kendaraan->id . "'>" . $aset->kendaraan->no_polisi . " - " . $aset->kendaraan->merk . " (" . $aset->kendaraan->tipe . ")" . "</option>";
        foreach ($kendaraan as $dt) {
            $html .= "<option value='$dt->id'>$dt->no_polisi - $dt->merk ($dt->tipe)</option>";
        }
        $html .= "
          </select>
            </div>
            <div class='col-md-3 mb-3'>
            <label for='no_aset'>Nomor Aset</label>
                <input type='text' class='form-control' name='no_aset' id='no_aset' placeholder='Nomor Aset' value='$aset->no_aset'>
            </div>
            <div class='col-md-3 mb-3'>
            <label for='no_polis'>Nomor Polis</label>
                <input type='text' class='form-control' name='no_polis' id='no_polis' placeholder='Nomor Polis' value='$aset->no_polis'>
            </div>
            <div class='col-md-3 mb-3'>
            <label for='no_rangka'>Nomor Rangka</label>
                <input type='text' class='form-control' name='no_rangka' id='no_rangka' placeholder='Nomor Rangka' value='$aset->no_rangka'>
            </div>
            <div class='col-md-3 mb-3'>
            <label for='no_mesin'>Nomor Mesin</label>
                <input type='text' class='form-control' name='no_mesin' id='no_mesin' placeholder='Nomor Mesin' value='$aset->no_mesin'>
            </div>
            <div class='col-md-3 mb-3'>
            <label for='masa_pajak'>Masa Pajak</label>
                <input type='date' class='form-control' name='masa_pajak' id='masa_pajak' placeholder='Masa Pajak' value='$aset->masa_pajak'>
            </div>
            <div class='col-md-3 mb-3'>
            <label for='masa_stnk'>Masa STNK</label>
                <input type='date' class='form-control' name='masa_stnk' id='masa_stnk' placeholder='Masa STNK' value='$aset->masa_stnk'>
            </div>
            <div class='col-md-3 mb-3'>
            <label for='masa_asuransi'>Masa Asuransi</label>
                <input type='date' class='form-control' name='masa_asuransi' id='masa_asuransi' placeholder='Masa Asuransi' value='$aset->masa_asuransi'>
            </div>
            <div class='col-md-3 mb-3'>
            <label for='tgl_service_rutin'>Tanggal Service Rutin</label>
                <input type='date' class='form-control' name='tgl_service_rutin' id='tgl_service_rutin' placeholder='Tanggal Service Rutin' value='$aset->tgl_service_rutin'>
            </div>
            <div class='col-md-6 mb-3'>
            <label for='tahun_pembuatan'>Tahun Pembuatan</label>
                <input type='number' class='form-control' name='tahun_pembuatan' id='tahun_pembuatan' placeholder='Tahun Pembuatan' value='$aset->tahun_pembuatan'>
            </div>
            <div class='col-md-6 mb-3'>
            <label for='tahun_pengadaan'>Tahun Pengadaan</label>
                <input type='number' class='form-control' name='tahun_pengadaan' id='tahun_pengadaan' placeholder='Tahun Pengadaan' value='$aset->tahun_pengadaan'>
            </div>
        </div>
        ";
        return $html;
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

    public function editAset(Request $request)
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

        $aset = AsetKendaraan::find($request->id);
        $aset->update($request->all());

        return redirect()->back()->with('success', 'Data berhasil diubah');
    }

    public function deleteAset(Request $request)
    {
        $aset = AsetKendaraan::find($request->id);
        $aset->delete();

        return redirect()->back()->with('success', 'Data berhasil dihapus');
    }

    public function getService(ServiceKendaraan $service)
    {
        $kendaraan = Kendaraan::all();
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

        $html = "
        <input type='hidden' name='id' value='$service->id'>
        <div class='row'>
            <div class='col-md-4 mb-3'>
            <label for='kendaraan_id_service'>Kendaraan</label>
            <select class='form-select' name='kendaraan_id_service' id='kendaraan_id_service'>
            <option value='" . $service->kendaraan->id . "'>" . $service->kendaraan->no_polisi . " - " . $service->kendaraan->merk . " (" . $service->kendaraan->tipe . ")" . "</option>";
        foreach ($kendaraan as $dt) {
            $html .= "<option value='$dt->id'>$dt->no_polisi - $dt->merk ($dt->tipe)</option>";
        }
        $html .= "
            </select>
            </div>
            <div class='col-md-4 mb-3'>
            <label for='kode'>Kode Service</label>
            <select class='form-select' name='kode' id='kode'>
                <option value='" . $service->kode . "'>" . $service->kode . "</option>";
        foreach ($kodeService as $dt) {
            $html .= "<option value='{$dt['code']} - {$dt['keterangan']}'>{$dt['code']} - {$dt['keterangan']}</option>";
        }
        $html .= "
            </select>
            </div>
            <div class='col-md-4 mb-3'>
            <label for='tgl_service'>Tanggal Service</label>
            <input type='date' class='form-control' name='tgl_service' id='tgl_service' placeholder='Tanggal Service' value='$service->tgl_service'>
            </div>
            <div class='col-md-12 mb-3'>
            <label for='uraian'>Uraian</label>
            <textarea class='form-control' name='uraian' id='uraian' rows='3'>$service->uraian</textarea>
            </div>
        </div>
        ";

        return $html;
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

    public function editService(Request $request)
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
        $service = ServiceKendaraan::find($request->id);
        $service->update($request->all());

        return redirect()->back()->with('success', 'Data berhasil diubah');
    }

    public function deleteService(Request $request)
    {
        $service = ServiceKendaraan::find($request->id);
        $service->delete();

        return redirect()->back()->with('success', 'Data berhasil dihapus');
    }

    public function rekap()
    {
        $aset = AsetKendaraan::all();
        $service = ServiceKendaraan::all();
        return view('master-data.asset-service-rekap', compact('aset', 'service'));
    }
}
