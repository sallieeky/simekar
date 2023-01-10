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
            'nama' => 'User',
            'email' => 'user1@gmail.com',
            'password' => bcrypt('user12345'),
            'role' => 'user',
            'no_hp' => '081243942304'
        ]);
    }
}
