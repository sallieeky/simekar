<?php

namespace Database\Seeders;

use App\Models\Peminjaman;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PeminjamanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Peminjaman::create([
            'user_id' => 2,
            'driver_id' => 1,
            'kendaraan_id' => 1,
            'tujuan_peminjaman_id' => 1,
            'keperluan' => "awdawd",
            'status' => "dipakai",
            'waktu_peminjaman' => date('Y-m-d H:i:s'),
            'waktu_selesai' => date('Y-m-d H:i:s'),
        ]);
        Peminjaman::create([
            'user_id' => 3,
            'tujuan_peminjaman_id' => 1,
            'keperluan' => "awdawd",
            'status' => "menunggu",
            'waktu_peminjaman' => date('Y-m-d H:i:s'),
            'waktu_selesai' => date('Y-m-d H:i:s'),
        ]);
        Peminjaman::create([
            'user_id' => 4,
            'tujuan_peminjaman_id' => 1,
            'keperluan' => "awdawd",
            'status' => "menunggu",
            'waktu_peminjaman' => date('Y-m-d H:i:s'),
            'waktu_selesai' => date('Y-m-d H:i:s'),
        ]);
    }
}
