<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Menghapus user yang mungkin sudah ada dengan id atau username yang sama
        User::where('username', 'fabio')->delete();

        // Membuat user baru
        User::create([
            'name'     => 'Fabio',
            'nama_lengkap' => 'Fabio',
            'role_name' => 'admin',
            'nomor_telepon' => '08765432',
            'email' => 'fabio@gmail.com',
            'username' => 'fabio',
            'password' => Hash::make('fabio2424'), // Password 'fabio2424' di-hash di sini
        ]);
    }
}
