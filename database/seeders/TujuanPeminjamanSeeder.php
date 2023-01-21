<?php

namespace Database\Seeders;

use App\Models\TujuanPeminjaman;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TujuanPeminjamanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TujuanPeminjaman::create([
            'nama' => "ITK",
            'alamat' => "Sei Wain",
        ]);
        TujuanPeminjaman::create([
            'nama' => "ITK",
            'alamat' => "KM 15",
        ]);
    }
}
