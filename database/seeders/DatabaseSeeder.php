<?php

namespace Database\Seeders;

use App\Models\Jenis;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Buat Role & User dulu
        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
        ]);

        // 2. Buat data Jenis bawaan dengan nama kolom 'nama_jenis'
        $user = User::first();
        $jenisList = ['Makanan', 'Minuman', 'Elektronik', 'Pakaian'];

        foreach ($jenisList as $namaJenis) {
            Jenis::firstOrCreate(
                ['nama_jenis' => $namaJenis], // <-- Disesuaikan ke 'nama_jenis'
                ['user_id' => $user ? $user->id : 1]
            );
        }

        // 3. Panggil ProdukSeeder & PenjualanSeeder
        $this->call([
            ProdukSeeder::class,
            PenjualanSeeder::class,
        ]);
    }
}