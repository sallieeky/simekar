<?php

namespace App\Http\Controllers;

use App\Models\Kendaraan;
use App\Models\Reimbursement;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class ReimbursementController extends Controller
{
    public function pengajuan()
    {
        if (Auth::user()->role == 'user') {
            $kendaraan = Kendaraan::all();
            return view('reimbursement.user.pengajuan', compact('kendaraan'));
        } else {
            $reimbursement = Reimbursement::where('status', 'Dalam proses pengajuan')->orderBy('created_at', "ASC")->get();
            return view('reimbursement.admin.pengajuan', compact('reimbursement'));
        }
    }

    public function pengajuanPost(Request $request)
    {
        $request->validate([
            'kendaraan_id' => 'required',
            'km_tempuh' => 'required|regex:/^[0-9.]+$/',
            'nominal' => 'required|regex:/^[0-9.,]+$/',
        ], [
            'kendaraan_id.required' => 'Kendaraan harus dipilih',
            'km_tempuh.required' => 'KM tempuh tidak boleh kosong',
            'km_tempuh.regex' => 'KM tempuh harus berupa angka',
            'nominal.required' => 'Nominal tidak boleh kosong',
            'nominal.regex' => 'Nominal harus berupa angka',
        ]);

        $nominal = str_replace(',', '', $request->nominal);

        $nomorReimburse = Reimbursement::whereMonth('created_at', Carbon::now()->month)->get()->count() + 1;
        Reimbursement::create([
            'user_id' => Auth::user()->id,
            'kendaraan_id' => $request->kendaraan_id,
            'km_tempuh' => $request->km_tempuh,
            'nomor_reimburse' => $nomorReimburse,
            'nominal' => $nominal,
        ]);



        return back()->with('success', 'Berhasil melakukan pengajuan reimbursement');
    }

    public function riwayat()
    {
        $reimbursement = Reimbursement::where('user_id', Auth::user()->id)->get();
        return view('reimbursement.user.riwayat', compact('reimbursement'));
    }

    public function riwayatNota(Request $request, $aksi)
    {
        $pdf = app('dompdf.wrapper');
        $reimbursement = Reimbursement::where('id', $request->id)->first();

        $pdf->loadView('pdf.nota-riwayat-reimbursement', compact('reimbursement'));

        if ($aksi == "unduh") {
            $namaFile = "nota-reimbursement-" . date('Y-m-d') . ".pdf";
            return $pdf->download($namaFile);
        } else if ($aksi == "lihat") {
            return $pdf->stream();
        }
    }

    public function rekap()
    {
        $data = Reimbursement::where('status', '!=', 'Dalam proses pengajuan')->get();
        return view('reimbursement.admin.rekap', compact('data'));
    }

    public function pengajuanRespon(Request $request)
    {
        Reimbursement::find($request->id)
            ->update([
                "keterangan" => $request->keterangan,
                "status" => $request->status == "setuju" ? "Pengajuan disetujui" : "Pengajuan ditolak",
            ]);
        return back()->with('success', "Berhasil merespon reimbursement");
    }

    public function rekapExport(Request $request)
    {
        $data = Reimbursement::with('kendaraan', 'user')
            ->whereDate('created_at', '>=', $request->tanggal_dari)
            ->whereDate('created_at', '<=', $request->tanggal_sampai)
            ->where("status", "!=", "Dalam proses pengajuan")
            ->orderBy('created_at', 'asc')
            ->get();

        if ($data->count() == 0) {
            return false;
        }

        $filename = "rekap-reimbursement-" . date('Y-m-d') . ".csv";
        $handle = fopen($filename, 'w+');

        fputcsv($handle, array('Tanggal Dari', $request->tanggal_dari), ';');
        fputcsv($handle, array('Tanggal Sampai', $request->tanggal_sampai), ';');

        fputcsv($handle, array('Nomor', 'Nomor Surat', 'Tanggal Pengajuan', 'Nama Pegawai', 'Nomor Handphone', 'Nomor Polisi', 'KM Tempuh', 'Nominal', 'Keterangan'), ';');

        $no = 1;
        foreach ($data as $row) {
            $nomorReimburse = $row->nomor_reimburse;
            if ($nomorReimburse < 10) {
                $nomorReimburse = '00' . $nomorReimburse;
            } elseif ($nomorReimburse < 100) {
                $nomorReimburse = '0' . $nomorReimburse;
            }
            $ns = "UMUM/RBM/$nomorReimburse/" . date('m', strtotime($row->created_at)) . "/" . date('Y', strtotime($row->created_at));
            fputcsv($handle, array($no, $ns, Carbon::parse($row->created_at)->translatedFormat('l, d F Y H:i'), $row->user->nama, $row->user->no_hp, $row->kendaraan->no_polisi, $row->km_tempuh, $row->nominal, $row->keterangan ? $row->keterangan : "Tanpa Keterangan"), ';');
            $no++;
        }
        fclose($handle);
        $headers = array(
            'Content-Type' => 'text/csv',
        );

        return Response::download($filename, $filename, $headers)->deleteFileAfterSend(true);
    }
}
