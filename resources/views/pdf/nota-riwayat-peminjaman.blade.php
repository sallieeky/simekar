<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nota Pemakaian Kendaraan</title>

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
    <h3 style="text-decoration: underline; text-align: center">NOTA PERSETUJUAN PEMAKAIAN</h3>

    <p style="text-align: right; font-size: 12px; margin: 16px 0;">Balikpapan, {{ Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>

    <table align="center">
        <tr align="justify">
            <td width="20%">Nomor</td>
            @php
                $nomor_peminjaman = $peminjaman->nomor_peminjaman;
                if ($nomor_peminjaman < 10) {
                    $nomor_peminjaman = '00' . $nomor_peminjaman;
                } elseif ($nomor_peminjaman < 100) {
                    $nomor_peminjaman = '0' . $nomor_peminjaman;
                }
            @endphp
            <td width="80%">: UMUM/PKR/{{ $nomor_peminjaman }}/{{ date('m', strtotime($peminjaman->created_at)) }}/{{ date('Y', strtotime($peminjaman->created_at)) }}</td>
        </tr>
        <tr align="justify">
            <td width="20%">Hal</td>
            <td width="80%">: Pemakaian Kendaraan</td> 
        </tr>
    </table>

    <div style="margin: 32px 0;">
        <p>Yth. {{ $peminjaman->user->nama }}</p>
        <p>Persetujuan Pemakaian kendaraan anda telah disetujui dengan ketentuan sebagai berikut:</p>

        <table align="center" style="margin-top: 16px">
            <tr align="justify">
                <td width="20%" valign="top">Nomor Polisi</td>
                <td width="1%" valign="top">:</td>
                <td width="79%">{{ $peminjaman->kendaraan->no_polisi }}</td>
            </tr>
            <tr align="justify">
                <td width="20%" valign="top">Merk</td>
                <td width="1%" valign="top">:</td>
                <td width="79%">{{ $peminjaman->kendaraan->merk }}</td>
            </tr>
            <tr align="justify">
                <td width="20%" valign="top">Tipe</td>
                <td width="1%" valign="top">:</td>
                <td width="79%">{{ $peminjaman->kendaraan->tipe }}</td>
            </tr>
            <tr align="justify">
                <td width="20%" valign="top">Driver</td>
                <td width="1%" valign="top">:</td>
                <td width="79%">@isset($peminjaman->driver->nama) {{ $peminjaman->driver->nama }} @else Tanpa Driver @endisset</td>
            </tr>
            <tr align="justify">
                <td width="20%" valign="top">Tanggal Pinjam</td>
                <td width="1%" valign="top">:</td>
                <td width="79%">{{ Carbon\Carbon::parse($peminjaman->waktu_peminjaman)->translatedFormat('l, d F Y H:i') }}</td>
            </tr>
            <tr align="justify">
                <td width="20%" valign="top">Tanggal Kembali</td>
                <td width="1%" valign="top">:</td>
                <td width="79%">{{ Carbon\Carbon::parse($peminjaman->waktu_selesai)->translatedFormat('l, d F Y H:i') }}</td>
            </tr>
            <tr align="justify">
                <td width="20%" valign="top">Tujuan</td>
                <td width="1%" valign="top">:</td>
                <td width="79%">{{ $peminjaman->tujuan_peminjaman->nama }}</td>
            </tr>
            <tr align="justify">
                <td width="20%" valign="top">Alamat Tujuan</td>
                <td width="1%" valign="top">:</td>
                <td width="79%">{{ $peminjaman->tujuan_peminjaman->alamat }}</td>
            </tr>
            <tr align="justify">
                <td width="20%" valign="top">Keperluan</td>
                <td width="1%" valign="top">:</td>
                <td width="79%">{{ $peminjaman->keperluan }}</td>
            </tr>
        </table>
    </div>

    <p style="text-align: justify">Harap melakukan konfirmasi apabila telah selesai melakukan pemakaian. Dan menghubungi pihak <span style="font-weight: 700">Sub Bagian Umum</span> apabila ada kendala dalam pemakain.</p>

    <p style="margin-top: 32px; text-align:right">Umum PT. Jasa Raharja Cabang Kalimantan Timur</p>

</body>
</html>