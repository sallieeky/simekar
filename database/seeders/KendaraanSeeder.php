<?php

namespace Database\Seeders;

use App\Models\Kendaraan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KendaraanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $file = fopen(public_path('kendaraan.csv'), 'r');
        // $i = 1;
        // while (($row = fgetcsv($file, 1000, ",")) !== FALSE) {
        //     $data = explode(";", $row[0]);
        //     Kendaraan::create([
        //         'no_polisi' => $data[0],
        //         'merk' => $data[1],
        //         'tipe' => $data[2],
        //     ]);
        //     $i++;
        //     if ($i == 6) break;
        // }
        // fclose($file);

        $file = fopen(public_path('kendaraan2.csv'), 'r');
        $i = 1;
        while (($row = fgetcsv($file, 1000, ",")) !== FALSE) {
            if ($i == 1 || $i == 2) {
                $i++;
                continue;
            }
            $data = explode(";", $row[0]);
            Kendaraan::create([
                'no_polisi' => $data[4],
                'merk' => $data[2],
                'tipe' => $data[3],
            ]);
        }

        fclose($file);
    }
}
