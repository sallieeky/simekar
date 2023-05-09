<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'nama' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('admin12345'),
            'role' => 'admin',
            'no_hp' => '081234567890'
        ]);

        User::create([
            'nama' => "Yus Fadillah",
            "email" => "10191059@student.itk.ac.id",
            "password" => bcrypt("yus12345"),
            'role' => 'user',
            'no_hp' => '081717616711'
        ]);

        $file = fopen(public_path('user.csv'), 'r');
        $i = 1;
        while (($row = fgetcsv($file, 1000, ",")) !== FALSE) {
            if ($i == 1) {
                $i++;
                continue;
            }
            $data = explode(";", $row[0]);
            User::create([
                'nama' => $data[0],
                'email' => $data[3],
                'password' => bcrypt($data[4]),
                'role' => 'user',
                'no_hp' => $data[1]
            ]);
            $i++;
        }

        fclose($file);
    }
}
