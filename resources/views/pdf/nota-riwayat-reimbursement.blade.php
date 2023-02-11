<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nota Persetujuan Reimburse BBM</title>

    <link rel="icon" href="logo_nota.jpeg" type="image/x-icon">

    <style>
        * {
            font-family: 'Times New Roman', Times, serif;
        }

        table, th, td {
            border: 0px solid black;
            border-collapse: collapse;
            font-size: 14px;
            line-height: 1.5;
        }

        table {
            width: 100%;
        }

        p {
            font-size: 14px;
            margin: 0;
        }
    </style>
</head>

<body style="margin: 3rem 1rem">
    <img src="logo_nota.jpeg" alt="logo" width="20%" style="position: absolute; top: 0">
    <h3 style="text-decoration: underline; text-align: center">NOTA PERSETUJUAN REIMBURSE BBM</h3>

    <p style="text-align: right; font-size: 12px; margin: 16px 0;">Balikpapan, {{ Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>

    <table align="center">
        <tr align="justify">
            <td width="20%">Nomor</td>
            @php
                $nomorReimburse = $reimbursement->nomor_reimburse;
                if ($nomorReimburse < 10) {
                    $nomorReimburse = '00' . $nomorReimburse;
                } elseif ($nomorReimburse < 100) {
                    $nomorReimburse = '0' . $nomorReimburse;
                }
            @endphp
            <td width="80%">: UMUM/RBM/{{ $nomorReimburse }}/{{ date('m', strtotime($reimbursement->created_at)) }}/{{ date('Y', strtotime($reimbursement->created_at)) }}</td>
        </tr>
        <tr align="justify">
            <td width="20%">Hal</td>
            <td width="80%">: Reimburse BBM</td> 
        </tr>
    </table>

    <div style="margin: 32px 0;">
        <p>Yth. {{ $reimbursement->user->nama }}</p>
        <p>Persetujuan Reimburse dana BBM anda telah disetujui dengan ketentuan sebagai berikut:</p>

        <table align="center" style="margin-top: 16px">
            <tr align="justify">
                <td width="20%" valign="top">Tanggal Pengajuan</td>
                <td width="1%" valign="top">:</td>
                <td width="79%">{{ Carbon\Carbon::parse($reimbursement->created_at)->translatedFormat('l, d F Y H:i') }}</td>
            </tr>
            <tr align="justify">
                <td width="20%" valign="top">Nomor Polisi</td>
                <td width="1%" valign="top">:</td>
                <td width="79%">{{ $reimbursement->kendaraan->no_polisi }}</td>
            </tr>
            <tr align="justify">
                <td width="20%" valign="top">KM Tempuh</td>
                <td width="1%" valign="top">:</td>
                <td width="79%">{{ $reimbursement->km_tempuh }}</td>
            </tr>
            <tr align="justify">
                <td width="20%" valign="top">Nominal</td>
                <td width="1%" valign="top">:</td>
                <td width="79%">Rp. {{ number_format($reimbursement->nominal, 2, ',', '.') }}</td>
            </tr>
            <tr align="justify">
                <td width="20%" valign="top">Keterangan</td>
                <td width="1%" valign="top">:</td>
                <td width="79%">{{ $reimbursement->keterangan ? $reimbursement->keterangan : "Tanpa Keterangan" }}</td>            
            </tr>
        </table>
    </div>
    <p style="text-align: justify">Harap menyimpan nota pembelian BBM dan menyerahkan ke pihak <span style="font-weight: 700">Sub Bagian Umum</span> untuk segera diproses.</p>

    <p style="margin-top: 32px; text-align:right">Umum PT. Jasa Raharja Cabang Kalimantan Timur</p>
</body>
</html>