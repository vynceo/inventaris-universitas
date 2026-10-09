<?php

namespace Database\Seeders;

use App\Models\Barang;
use Illuminate\Database\Seeder;

class BarangSeeder extends Seeder
{
    public function run(): void
    {
        Barang::create([
            'kategori_id' => 4,
            'nama'        => 'Laptop HP Pavilion',
            'jumlah'      => 10,
            'kondisi'     => 'baik',
            'deskripsi'   => 'Laptop HP Pavilion 14 inch, RAM 8GB, SSD 256GB',
        ]);

        Barang::create([
            'kategori_id' => 4,
            'nama'        => 'Desktop PC',
            'jumlah'      => 5,
            'kondisi'     => 'baik',
            'deskripsi'   => 'Desktop PC Intel Core i5, RAM 16GB',
        ]);

        Barang::create([
            'kategori_id' => 1,
            'nama'        => 'Proyektor Epson',
            'jumlah'      => 3,
            'kondisi'     => 'baik',
            'deskripsi'   => 'Proyektor Epson EB-X51',
        ]);

        Barang::create([
            'kategori_id' => 2,
            'nama'        => 'Meja Kantor',
            'jumlah'      => 20,
            'kondisi'     => 'baik',
            'deskripsi'   => 'Meja kantor ukuran 120x60 cm',
        ]);

        Barang::create([
            'kategori_id' => 2,
            'nama'        => 'Kursi Kantor',
            'jumlah'      => 25,
            'kondisi'     => 'baik',
            'deskripsi'   => 'Kursi kantor ergonomis',
        ]);

        Barang::create([
            'kategori_id' => 3,
            'nama'        => 'Spidol Whiteboard',
            'jumlah'      => 50,
            'kondisi'     => 'baik',
            'deskripsi'   => 'Spidol whiteboard berbagai warna',
        ]);
    }
}
