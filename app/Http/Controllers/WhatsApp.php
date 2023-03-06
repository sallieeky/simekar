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

  public static function masukAntrianKendaraan_Admin($data)
  {
    $pesan = "Halo Admin,

      Kami ingin memberitahukan bahwa $data[nama_pegawai] sedang dalam antrian peminjaman kendaraan dan sedang menunggu ketersediaan driver.
      
      Terima kasih atas perhatiannya.
    ";

    $pesan = nl2br($pesan);
    $pesan = str_replace("<br />", "", $pesan);
    $pesan = str_replace("      ", "", $pesan);
    $pesan = urlencode($pesan);

    return self::send(env("WA_ADMIN"), $pesan);
  }

  public static function masukAntrianKendaraan_User($data)
  {
    $pesan = "Halo $data[nama_pegawai],

      Terima kasih telah menggunakan layanan peminjaman kendaraan kami.
      Kami ingin memberitahu bahwa status anda sedang dalam antrian untuk melakukan peminjaman kendaraan dan saat ini kami sedang mencari driver yang tersedia untuk melayani Anda.
      Mohon bersabar dan tunggu sebentar, sistem akan segera menghubungi Anda setelah driver tersedia.
      
      Terima kasih atas kesabaran dan pengertiannya.    
    ";

    $pesan = nl2br($pesan);
    $pesan = str_replace("<br />", "", $pesan);
    $pesan = str_replace("      ", "", $pesan);
    $pesan = urlencode($pesan);

    return self::send($data["nohp_pegawai"], $pesan);
  }

  public static function mendapatkanKendaraanSetelahMenungguPadaAntrian_Admin($data)
  {
    $pesan = "Halo Admin,

      Ini adalah pemberitahuan bahwa $data[nama_pegawai] telah mendapatkan ketersediaan driver setelah menunggu pada antrian kendaraan. Berikut adalah detail peminjaman kendaraan:
      
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

  public static function mendapatkanKendaraanSetelahMenungguPadaAntrian_Driver($data)
  {
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
    ";

    $pesan = nl2br($pesan);
    $pesan = str_replace("<br />", "", $pesan);
    $pesan = str_replace("      ", "", $pesan);
    $pesan = urlencode($pesan);

    return self::send($data["nohp_driver"], $pesan);
  }

  public static function mendapatkanKendaraanSetelahMenungguPadaAntrian_User($data)
  {
    $pesan = "Halo $data[nama_pegawai],

      Kami ingin memberitahukan bahwa peminjaman  Anda telah berhasil dilakukan setelah menunggu pada antrian kendaraan.
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

    return self::send($data["nohp_pegawai"], $pesan);
  }

  public static function melakukanKonfirmasiSelesaiPeminjaman_Admin($data)
  {
    $pesan = "Halo Admin

      Kami ingin memberitahu bahwa peminjaman kendaraan atas nama $data[nama_pegawai] dengan menggunakan kendaraan $data[no_polisi] dan ditemani $data[nama_driver] telah selesai dilakukan.
      
      Terima kasih .
    ";

    $pesan = nl2br($pesan);
    $pesan = str_replace("<br />", "", $pesan);
    $pesan = str_replace("      ", "", $pesan);
    $pesan = urlencode($pesan);

    return self::send(env("WA_ADMIN"), $pesan);
  }

  public static function melakukanKonfirmasiSelesaiPeminjaman_Driver($data)
  {
    $pesan = "Halo $data[nama_driver]

      Kami ingin memberitahu bahwa peminjaman kendaraan atas nama $data[nama_pegawai] dengan menggunakan kendaraan $data[no_polisi] dan ditemani driver yang ditugaskan adalah Anda telah selesai dilakukan.
      
      Terima kasih .
    ";

    $pesan = nl2br($pesan);
    $pesan = str_replace("<br />", "", $pesan);
    $pesan = str_replace("      ", "", $pesan);
    $pesan = urlencode($pesan);

    return self::send($data["nohp_driver"], $pesan);
  }

  public static function melakukanKonfirmasiSelesaiPeminjaman_User($data)
  {
    $pesan = "Halo $data[nama_pegawai],

      Kami ingin memberitahu bahwa peminjaman Anda dengan menggunakan kendaraan $data[no_polisi] telah selesai dilakukan.
      
      Terima kasih telah menggunakan layanan kami.
    ";

    $pesan = nl2br($pesan);
    $pesan = str_replace("<br />", "", $pesan);
    $pesan = str_replace("      ", "", $pesan);
    $pesan = urlencode($pesan);

    return self::send($data["nohp_pegawai"], $pesan);
  }

  public static function melakukanKonfirmasiSelesaiPeminjamanAdmin_Admin($data)
  {
    $pesan = "Halo Admin

      Kami ingin memberitahu bahwa peminjaman kendaraan atas nama $data[nama_pegawai] dengan menggunakan kendaraan $data[no_polisi] dan ditemani $data[nama_pegawai] status peminjamannya telah diselesaikan oleh Admin.
      
      Terima kasih .    
    ";

    $pesan = nl2br($pesan);
    $pesan = str_replace("<br />", "", $pesan);
    $pesan = str_replace("      ", "", $pesan);
    $pesan = urlencode($pesan);

    return self::send(env("WA_ADMIN"), $pesan);
  }

  public static function melakukanKonfirmasiSelesaiPeminjamanAdmin_Driver($data)
  {
    $pesan = "Halo $data[nama_driver]

      Kami ingin memberitahu bahwa peminjaman kendaraan atas nama $data[nama_pegawai] dengan menggunakan kendaraan $data[no_polisi] dan ditemani driver yang ditugaskan adalah Anda  bahwa status peminjaman telah diselesaikan oleh Admin.
      
      Terima kasih .
    ";

    $pesan = nl2br($pesan);
    $pesan = str_replace("<br />", "", $pesan);
    $pesan = str_replace("      ", "", $pesan);
    $pesan = urlencode($pesan);

    return self::send($data["nohp_driver"], $pesan);
  }

  public static function melakukanKonfirmasiSelesaiPeminjamanAdmin_User($data)
  {
    $pesan = "Halo $data[nama_pegawai],

      Kami ingin memberitahu bahwa peminjaman Anda dengan menggunakan kendaraan $data[no_polisi] status peminjaman telah diselesaikan oleh Admin.
      
      Terima kasih telah menggunakan layanan kami.
    ";

    $pesan = nl2br($pesan);
    $pesan = str_replace("<br />", "", $pesan);
    $pesan = str_replace("      ", "", $pesan);
    $pesan = urlencode($pesan);

    return self::send($data["nohp_pegawai"], $pesan);
  }

  public static function melakukanPembatalanPeminjamanDiAntrianKendaraan_Admin($data)
  {
    $pesan = "Halo Admin,

      Kami ingin memberitahu Anda bahwa peminjaman kendaraan yang diajukan $data[nama_pegawai] yang statusnya sedang dalam antrian telah dibatalkan lewat sistem.
      
      Terima kasih.
    ";

    $pesan = nl2br($pesan);
    $pesan = str_replace("<br />", "", $pesan);
    $pesan = str_replace("      ", "", $pesan);
    $pesan = urlencode($pesan);

    return self::send(env("WA_ADMIN"), $pesan);
  }

  public static function melakukanPembatalanPeminjamanDiAntrianKendaraan_User($data)
  {
    $pesan = "Halo $data[nama_pegawai],

      Kami ingin memberitahu Anda bahwa peminjaman kendaraan yang Anda ajukan yang statusnya sedang dalam antrian telah dibatalkan lewat sistem.
      
      Silakan hubungi Admin jika Anda memiliki pertanyaan atau ingin membahas opsi lain untuk mendapatkan kendaraan yang Anda butuhkan.
      
      Terima kasih atas pengertian dan kerja sama Anda.
    ";

    $pesan = nl2br($pesan);
    $pesan = str_replace("<br />", "", $pesan);
    $pesan = str_replace("      ", "", $pesan);
    $pesan = urlencode($pesan);

    return self::send($data["nohp_pegawai"], $pesan);
  }

  public static function melakukanPembatalanPeminjamanDiAntrianKendaraanAdmin_Admin($data)
  {
    $pesan = "Halo Admin,

      Kami ingin memberitahu Anda bahwa peminjaman kendaraan yang diajukan $data[nama_pegawai] yang statusnya sedang dalam antrian telah dibatalkan oleh anda.
      
      Terima kasih.
    ";

    $pesan = nl2br($pesan);
    $pesan = str_replace("<br />", "", $pesan);
    $pesan = str_replace("      ", "", $pesan);
    $pesan = urlencode($pesan);

    return self::send(env("WA_ADMIN"), $pesan);
  }

  public static function melakukanPembatalanPeminjamanDiAntrianKendaraanAdmin_User($data)
  {
    $pesan = "Halo $data[nama_pegawai],

      Kami ingin memberitahu Anda bahwa peminjaman kendaraan yang Anda ajukan yang statusnya sedang dalam anntrian telah dibatalkan oleh admin.
      
      Silakan hubungi Admin jika Anda memiliki pertanyaan atau ingin membahas opsi lain untuk mendapatkan kendaraan yang Anda butuhkan.
      
      Terima kasih atas pengertian dan kerja sama Anda.
    ";

    $pesan = nl2br($pesan);
    $pesan = str_replace("<br />", "", $pesan);
    $pesan = str_replace("      ", "", $pesan);
    $pesan = urlencode($pesan);

    return self::send($data["nohp_pegawai"], $pesan);
  }

  public static function pengajuanReimburseMasukDiproses_Admin($data)
  {
    $pesan = "Halo Admin,

      Kami ingin memberitahu bahwa sistem telah menerima pengajuan biaya reimburse BBM yang dilakukan $data[nama_pegawai] telah berhasil diajukan.
      Berikut adalah detail pengajuan tersebut:
      
      Nama Pegawai : $data[nama_pegawai]
      Tanggal Pengajuan : $data[tgl_pengajuan]
      Kendaraan : $data[no_polisi]
      Km Tempuh : $data[km_tempuh]
      Nominal Pengajuan : $data[nominal]
      
      Mohon untuk segera memproses pengajuan ini dengan mengkonfirmasi lewat sistem.
      
      Terima kasih.
    ";

    $pesan = nl2br($pesan);
    $pesan = str_replace("<br />", "", $pesan);
    $pesan = str_replace("      ", "", $pesan);
    $pesan = urlencode($pesan);

    return self::send(env("WA_ADMIN"), $pesan);
  }

  public static function pengajuanReimburseMasukDiproses_User($data)
  {
    $pesan = "Halo $data[nama_pegawai],

      Kami ingin memberitahu bahwa pengajuan biaya reimburse BBM Anda telah berhasil diajukan dan akan segera diproses oleh Sub Bagian Umum.  Berikut detail Pengajuan reimburse BBM:
      
      Tanggal Pengajuan : $data[tgl_pengajuan]
      Kendaraan : $data[no_polisi]
      Km Tempuh : $data[km_tempuh]
      Nominal Pengajuan : $data[nominal]
      
      Kami akan memberikan informasi lebih lanjut mengenai status pengajuan Anda apabila telah dikonfirmasi oleh Sub Bagian Umum.
      
      Terima kasih
    ";

    $pesan = nl2br($pesan);
    $pesan = str_replace("<br />", "", $pesan);
    $pesan = str_replace("      ", "", $pesan);
    $pesan = urlencode($pesan);

    return self::send($data["nohp_pegawai"], $pesan);
  }

  public static function reimburseDisetujui_User($data)
  {
    $pesan = "Halo $data[nama_pegawai],

      Kami ingin memberitahukan bahwa pengajuan biaya reimburse BBM Anda pada tanggal $data[tgl_pengajuan] telah DISETUJUI.
      Berikut detail Pengajuan reimburse BBM:
      
      Tanggal Pengajuan : $data[tgl_pengajuan]
      Kendaraan : $data[no_polisi]
      Km Tempuh : $data[km_tempuh]
      Nominal Pengajuan : $data[nominal]
      Keterangan : $data[keterangan]
      
      Harap Menyimpan Nota Asli pembelian BBM dan menyerahkan kepada pihak Sub Bagian Umum.
      
      Terima kasih.
    ";

    $pesan = nl2br($pesan);
    $pesan = str_replace("<br />", "", $pesan);
    $pesan = str_replace("      ", "", $pesan);
    $pesan = urlencode($pesan);

    return self::send($data["nohp_pegawai"], $pesan);
  }

  public static function reimburseDitolak_User($data)
  {
    $pesan = "Halo $data[nama_pegawai],

      Kami ingin memberitahukan bahwa pengajuan biaya reimburse BBM Anda pada tanggal $data[tgl_pengajuan] telah ditinjau dan DITOLAK dengan alasan $data[keterangan].
      
      Apabila pegawai memiliki pertanyaan atau keberatan terkait penolakan ini, silakan menghubungi Sub Bagian Umum untuk konsultasi lebih lanjut.
      
      Terima kasih.
    ";

    $pesan = nl2br($pesan);
    $pesan = str_replace("<br />", "", $pesan);
    $pesan = str_replace("      ", "", $pesan);
    $pesan = urlencode($pesan);

    return self::send($data["nohp_pegawai"], $pesan);
  }

  public static function reminderPajakKendaraan_Hmin14_Admin($data)
  {
    $pesan = "Halo Admin
 
      Ini adalah notifikasi untuk mengingatkan Anda bahwa masa berlaku pajak kendaraan Anda akan segera jatuh tempo dalam waktu 14 Hari lagi. 
      
      Mohon pastikan untuk membayar pajak kendaraan sebelum tanggal jatuh tempo
      
      Informasi Detail:
      
      Kendaraan: $data[merk] $data[tipe]
      Nomor Polisi: $data[no_polisi]
      Masa Berlaku Pajak: $data[masa_pajak]
      
      Terima kasih telah memperhatikan pesan ini. Jangan lupa untuk membayar pajak kendaraan sebelum tanggal jatuh tempo dan melakukan Update Tanggal Masa Berlaku pada sistem.
    ";

    $pesan = nl2br($pesan);
    $pesan = str_replace("<br />", "", $pesan);
    $pesan = str_replace("      ", "", $pesan);
    $pesan = urlencode($pesan);

    return self::send(env("WA_ADMIN"), $pesan);
  }

  public static function reminderPajakStnk_Hmin14_Admin($data)
  {
    $pesan = "Halo Admin
 
      Ini adalah notifikasi untuk mengingatkan Anda bahwa masa berlaku STNK kendaraan Anda akan segera jatuh tempo dalam waktu 14 Hari lagi. 
      
      Mohon pastikan untuk membayar pajak STNK kendaraan sebelum tanggal jatuh tempo dan melakukan Update Tanggal Masa Berlaku pada sistem.
      
      Informasi Detail:
      
      Kendaraan: [Merk] [Tipe
      Nomor Polisi: [nomor polisi kendaraan]
      Masa Berlaku Pajak: [Masa Berlaku STNK]
      
      Terima kasih telah memperhatikan pesan ini. Jangan lupa untuk membayar pajak STNK kendaraan sebelum tanggal jatuh tempo dan melakukan Update Tanggal Masa Berlaku pada sistem.
    ";

    $pesan = nl2br($pesan);
    $pesan = str_replace("<br />", "", $pesan);
    $pesan = str_replace("      ", "", $pesan);
    $pesan = urlencode($pesan);

    return self::send(env("WA_ADMIN"), $pesan);
  }

  public static function reminderPajakAsuransi_Hmin14_Admin($data)
  {
    $pesan = "Halo Admin
  
      Ini adalah notifikasi untuk mengingatkan Anda bahwa masa berlaku Asuransi kendaraan Anda akan segera jatuh tempo dalam waktu 14 Hari lagi. 
      
      Mohon pastikan untuk membayar Asuransi kendaraan sebelum tanggal jatuh tempo
      
      Informasi Detail:
      
      Kendaraan: [Merk] [Tipe
      Nomor Polisi: [nomor polisi kendaraan]
      Masa Berlaku Asuransi: [Masa Berlaku STNK]
      
      Terima kasih telah memperhatikan pesan ini. Jangan lupa untuk membayar Asuransi kendaraan dan melakukan Update Tanggal Masa Berlaku pada sistem.
    ";

    $pesan = nl2br($pesan);
    $pesan = str_replace("<br />", "", $pesan);
    $pesan = str_replace("      ", "", $pesan);
    $pesan = urlencode($pesan);

    return self::send(env("WA_ADMIN"), $pesan);
  }

  public static function reminderPajakKendaraan_Hplus3_Admin($data)
  {
    $pesan = "Halo Admin
 
      Ini adalah notifikasi untuk mengingatkan Anda bahwa masa berlaku pajak kendaraan Anda sudah jatuh tempo pada 3 Hari yang lalu. 
      
      Informasi Detail:
      
      Kendaraan: [Merk] [Tipe
      Nomor Polisi: [nomor polisi kendaraan]
      Masa Berlaku Pajak: [Masa Berlaku Pajak]
      
      Apabila Telah melakukan pembayaran Pajak Kendaraan harap  melakukan Update Tanggal Masa Berlaku Pajak Kendaraan pada sistem.    
    ";

    $pesan = nl2br($pesan);
    $pesan = str_replace("<br />", "", $pesan);
    $pesan = str_replace("      ", "", $pesan);
    $pesan = urlencode($pesan);

    return self::send(env("WA_ADMIN"), $pesan);
  }

  public static function reminderPajakStnk_Hplus3_Admin($data)
  {
    $pesan = "Halo Admin
  
      Ini adalah notifikasi untuk mengingatkan Anda bahwa masa berlaku pajak STNK kendaraan Anda sudah jatuh tempo pada 3 Hari yang lalu. 
      
      Informasi Detail:
      
      Kendaraan: [Merk] [Tipe
      Nomor Polisi: [nomor polisi kendaraan]
      Masa Berlaku STNK: [Masa Berlaku Pajak]
      
      Apabila Telah melakukan pembayaran Pajak STNK Kendaraan harap melakukan Update Tanggal Masa Berlaku Pajak STNK Kendaraan pada sistem.
    ";

    $pesan = nl2br($pesan);
    $pesan = str_replace("<br />", "", $pesan);
    $pesan = str_replace("      ", "", $pesan);
    $pesan = urlencode($pesan);

    return self::send(env("WA_ADMIN"), $pesan);
  }

  public static function reminderPajakAsuransi_Hplus3_Admin($data)
  {
    $pesan = "Halo Admin
 
      Ini adalah notifikasi untuk mengingatkan Anda bahwa masa berlaku Asuransi kendaraan Anda sudah jatuh tempo pada 3 Hari yang lalu. 
      
      Informasi Detail:
      
      Kendaraan: [Merk] [Tipe
      Nomor Polisi: [nomor polisi kendaraan]
      Masa Berlaku Asuransi: [Masa Berlaku Asuransi]
      
      Apabila Telah melakukan pembayaran Asuransi Kendaraan harap melakukan Update Tanggal Masa Berlaku Asuransi Kendaraan pada sistem.
    ";

    $pesan = nl2br($pesan);
    $pesan = str_replace("<br />", "", $pesan);
    $pesan = str_replace("      ", "", $pesan);
    $pesan = urlencode($pesan);

    return self::send(env("WA_ADMIN"), $pesan);
  }

  public static function reminderServiceRutinKendaraan_Admin($data)
  {
    $pesan = "Halo Admin 

      Ini adalah notifikasi untuk mengingatkan jadwal rutin service kendaraan
      
      Informasi Detail :
      
      Kendaraan: [Merk] [Tipe
      Nomor Polisi: [nomor polisi kendaraan]
      Tanggal Service Terakhir: [Tanggal Service Rutin]
      
      Terima kasih telah memperhatikan pesan ini. Jangan lupa untuk melakukan service rutin kendaraan dan melakukan Update jadwal service rutin pada sistem.
    ";

    $pesan = nl2br($pesan);
    $pesan = str_replace("<br />", "", $pesan);
    $pesan = str_replace("      ", "", $pesan);
    $pesan = urlencode($pesan);

    return self::send(env("WA_ADMIN"), $pesan);
  }
}
