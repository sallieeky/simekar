<?php

namespace App\Http\Controllers;

use Throwable;

class WhatsApp
{
  public static function send($no_tujuan, $pesan)
  {
    try {
      $curl = curl_init();
      $token = env('WA_BLAST_KEY');
      $phone = $no_tujuan;
      $message = $pesan;
      curl_setopt($curl, CURLOPT_URL, "https://jogja.wablas.com/api/send-message?phone=$phone&message=$message&token=$token");
      $result = curl_exec($curl);
      curl_close($curl);
    } catch (Throwable $th) {
      throw $th;
    } finally {
      return $result;
    }
  }

  public static function peminjamanBerhasilKendaraanDriver_Admin($data)
  {
    $data['waktu_peminjaman'] = date("d-m-Y H:i", strtotime($data['waktu_peminjaman']));
    $data['waktu_selesai'] = date("d-m-Y H:i", strtotime($data['waktu_selesai']));

    $pesan = "Dear ADMIN

      Kami ingin memberitahukan bahwa peminjaman kendaraan telah berhasil dilakukan oleh $data[nama_pegawai]. Berikut adalah detail peminjaman kendaraan:
      
      Nama Pegawai: $data[nama_pegawai]
      Nama Driver: $data[nama_driver]
      No Polisi Kendaraan : $data[no_polisi]
      Kendaraan yang Dipinjam: $data[merk] - $data[tipe]
      Waktu Peminjaman: $data[waktu_peminjaman] hingga $data[waktu_selesai]
      Tujuan: $data[tujuan]
      Alamat Tujuan: $data[alamat]
      Keperluan : $data[keperluan]
      
      Sekian dari informasi peminjaman yang dapat kami berikan
      
      Terima kasih.
    ";

    $pesan = nl2br($pesan);
    $pesan = str_replace("<br />", "", $pesan);
    $pesan = str_replace("      ", "", $pesan);
    $pesan = urlencode($pesan);

    return self::send(env("WA_ADMIN"), $pesan);
  }

  public static function peminjamanBerhasilKendaraanDriver_Driver($data)
  {
    $data['waktu_peminjaman'] = date("d-m-Y H:i", strtotime($data['waktu_peminjaman']));
    $data['waktu_selesai'] = date("d-m-Y H:i", strtotime($data['waktu_selesai']));

    $pesan = "Dear $data[nama_driver],

      Kami ingin memberitahukan bahwa Anda telah dipilih untuk bertugas dalam menemani dan mengantar $data[nama_pegawai] dalam keperluan kantor. Berikut adalah detail peminjaman kendaraan:
      
      Nama Pegawai: $data[nama_pegawai]
      No Polisi Kendaraan : $data[no_polisi]
      Kendaraan yang Dipinjam: $data[merk] - $data[tipe]
      Waktu Peminjaman: $data[waktu_peminjaman] hingga $data[waktu_selesai]
      Tujuan: $data[tujuan]
      Alamat Tujuan: $data[alamat]
      Keperluan : $data[keperluan]
      
      Silakan menghubungi pegawai untuk memberikan konfirmasi dan koordinasi lebih lanjut mengenai peminjaman kendaraan tersebut
      
      Terima kasih.
    ";

    $pesan = nl2br($pesan);
    $pesan = str_replace("<br />", "", $pesan);
    $pesan = str_replace("      ", "", $pesan);
    $pesan = urlencode($pesan);

    return self::send($data['nohp_driver'], $pesan);
  }

  public static function peminjamanBerhasilKendaraanDriver_User($data)
  {
    $data['waktu_peminjaman'] = date("d-m-Y H:i", strtotime($data['waktu_peminjaman']));
    $data['waktu_selesai'] = date("d-m-Y H:i", strtotime($data['waktu_selesai']));

    $pesan = "Halo $data[nama_pegawai],

      Kami ingin memberitahukan bahwa peminjaman kendaraan Anda telah berhasil tercatat dalam sistem kami.
      
      Berikut adalah detail peminjaman kendaraan Anda:
      
      Nama Driver: $data[nama_driver]
      No Polisi Kendaraan : $data[no_polisi]
      Kendaraan yang Dipinjam: $data[merk] - $data[tipe]
      Waktu Peminjaman: $data[waktu_peminjaman] hingga $data[waktu_selesai]
      Tujuan: $data[tujuan]
      Alamat Tujuan: $data[alamat]
      Keperluan : $data[keperluan]
      
      Silakan menghubungi driver untuk memberikan konfirmasi dan koordinasi lebih lanjut mengenai peminjaman kendaraan tersebut dan apabila telah selesai harap melakukan konfirmasi selesai peminjaman pada sistem
      
      Terima kasih
    ";

    $pesan = nl2br($pesan);
    $pesan = str_replace("<br />", "", $pesan);
    $pesan = str_replace("      ", "", $pesan);
    $pesan = urlencode($pesan);

    return self::send($data['nohp_pegawai'], $pesan);
  }

  public static function peminjamanBerhasilKendaraan_Admin($data)
  {
    $data['waktu_peminjaman'] = date("d-m-Y H:i", strtotime($data['waktu_peminjaman']));
    $data['waktu_selesai'] = date("d-m-Y H:i", strtotime($data['waktu_selesai']));

    $pesan = "Dear ADMIN

      Kami ingin memberitahukan bahwa peminjaman kendaraan telah berhasil dilakukan oleh $data[nama_pegawai]. Berikut adalah detail peminjaman kendaraan:
      
      Nama Pegawai: $data[nama_pegawai]
      No Polisi Kendaraan : $data[no_polisi]
      Kendaraan yang Dipinjam: $data[merk] - $data[tipe]
      Waktu Peminjaman: $data[waktu_peminjaman] hingga $data[waktu_selesai]
      Tujuan: $data[tujuan]
      Alamat Tujuan: $data[alamat]
      Keperluan : $data[keperluan]
      
      Sekian dari informasi peminjaman yang dapat kami berikan
      
      Terima kasih.
    ";

    $pesan = nl2br($pesan);
    $pesan = str_replace("<br />", "", $pesan);
    $pesan = str_replace("      ", "", $pesan);
    $pesan = urlencode($pesan);

    return self::send(env("WA_ADMIN"), $pesan);
  }

  public static function peminjamanBerhasilKendaraan_User($data)
  {
    $data['waktu_peminjaman'] = date("d-m-Y H:i", strtotime($data['waktu_peminjaman']));
    $data['waktu_selesai'] = date("d-m-Y H:i", strtotime($data['waktu_selesai']));

    $pesan = "Halo $data[nama_pegawai],

      Kami ingin memberitahukan bahwa peminjaman kendaraan Anda telah berhasil tercatat dalam sistem kami.
      
      Berikut adalah detail peminjaman kendaraan Anda:
      
      No Polisi Kendaraan : $data[no_polisi]
      Kendaraan yang Dipinjam: $data[merk] - $data[tipe]
      Waktu Peminjaman: $data[waktu_peminjaman] hingga $data[waktu_selesai]
      Tujuan: $data[tujuan]
      Alamat Tujuan: $data[alamat]
      Keperluan : $data[keperluan]
      
      Silakan menghubungi driver untuk memberikan konfirmasi dan koordinasi lebih lanjut mengenai peminjaman kendaraan tersebut dan apabila telah selesai harap melakukan konfirmasi selesai peminjaman pada sistem
      
      Terima kasih
    ";

    $pesan = nl2br($pesan);
    $pesan = str_replace("<br />", "", $pesan);
    $pesan = str_replace("      ", "", $pesan);
    $pesan = urlencode($pesan);

    return self::send($data['nohp_pegawai'], $pesan);
  }
}
