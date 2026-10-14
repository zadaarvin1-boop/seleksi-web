<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Barang;

class BarangSeeder extends Seeder
{
    public function run(): void
    {
        Barang::insert([
            [
                'kode_barang' => 'BRG001',
                'nama_barang' => 'Mouse Wireless',
                'harga' => 75000,
                'stok' => 20,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_barang' => 'BRG002',
                'nama_barang' => 'Keyboard',
                'harga' => 120000,
                'stok' => 15,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_barang' => 'BRG003',
                'nama_barang' => 'Flashdisk 32GB',
                'harga' => 65000,
                'stok' => 25,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_barang' => 'BRG004',
                'nama_barang' => 'Headset',
                'harga' => 95000,
                'stok' => 10,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_barang' => 'BRG005',
                'nama_barang' => 'Kabel Data',
                'harga' => 35000,
                'stok' => 30,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}