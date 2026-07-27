<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Penjualan;
use App\Models\ItemPenjualan;
use App\Models\User;
use App\Models\Produk;
use Illuminate\Support\Facades\DB;

class PenjualanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil semua ID user dan ID produk yang ada di database
        $userIds = User::pluck('id');
        $produkIds = Produk::pluck('id');

        // Validasi: pastikan user dan produk sudah ada sebelum membuat transaksi
        if ($userIds->isEmpty() || $produkIds->isEmpty()) {
            $this->command->error('Tabel users atau produk masih kosong! Jalankan UserSeeder dan ProdukSeeder terlebih dahulu.');
            return;
        }

        DB::transaction(function () use ($userIds, $produkIds) {

            Penjualan::factory()
                ->count(50)
                ->make([
                    // Ambil user_id acak dari tabel users
                    'user_id' => function () use ($userIds) {
                        return $userIds->random();
                    },
                ])
                ->each(function ($penjualan) use ($produkIds) {
                    // Simpan data Penjualan terlebih dahulu
                    $penjualan->save();

                    // Buat item penjualan dengan produk_id acak
                    $items = ItemPenjualan::factory()
                        ->count(rand(1, 5))
                        ->make([
                            'penjualan_id' => $penjualan->id,
                            'produk_id' => function () use ($produkIds) {
                                return $produkIds->random();
                            },
                        ]);

                    // Hitung total nilai subtotal
                    $total = $items->sum('subtotal');

                    // Simpan relasi items
                    $penjualan->itemPenjualan()->saveMany($items);

                    // Update total pembayaran penjualan
                    $penjualan->update([
                        'total_pembayaran' => $total,
                    ]);
                });
        });
    }
}