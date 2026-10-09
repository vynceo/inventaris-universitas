<?php

namespace Database\Seeders;

use App\Models\Kategori;
use Illuminate\Database\Seeder;

class KategoriSeeder extends Seeder
{
    public function run(): void
    {
        Kategori::create([
            'nama' => 'Elektronik',
            'deskripsi' => 'Barang elektronik dan perangkat keras',
        ]);

        Kategori::create([
            'nama' => 'Perabotan',
            'deskripsi' => 'Meja, kursi, lemari, dan perabotan lainnya',
        ]);

        Kategori::create([
            'nama' => 'Alat Tulis',
            'deskripsi' => 'Alat tulis kantor dan perlengkapan administrasi',
        ]);

        Kategori::create([
            'nama' => 'Komputer',
            'deskripsi' => 'Desktop, laptop, dan perangkat komputer',
        ]);
    }
}
