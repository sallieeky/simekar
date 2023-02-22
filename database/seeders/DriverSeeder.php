<?php

namespace Database\Seeders;

use App\Models\Driver;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DriverSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // buat data list nama driver yang ada di jasa raharja
        $listNamaDriver = [
            "Asep",
            "Budi",
            "Caca",
            // "Dedi",
            // "Euis",
            // "Fafa",
            // "Gaga",
            // "Haha",
            // "Ika",
            // "Jaja",
        ];

        // buat data list nomor hp driver yang ada di jasa raharja
        $listNoHpDriver = [
            "081234567890",
            "081234567891",
            "081234567892",
            // "081234567893",
            // "081234567894",
            // "081234567895",
            // "081234567896",
            // "081234567897",
            // "081234567898",
            // "081234567899",
        ];

        // insert data driver ke database
        for ($i = 0; $i < count($listNamaDriver); $i++) {
            Driver::create([
                "nama" => $listNamaDriver[$i],
                "no_hp" => $listNoHpDriver[$i],
            ]);
        }
    }
}
