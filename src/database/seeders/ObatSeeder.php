<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ObatSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('obats')->insert([
            [
                'kode_obat' => 'OB001',
                'nama' => 'Omeprazole',
                'kategori' => 'Kapsul',
                'jenis' => 'Generik',
                'stok' => 150,
                'harga' => 5000,
                'satuan' => 'strip',
            ],
            [
                'kode_obat' => 'OB002',
                'nama' => 'Amoxicillin',
                'kategori' => 'Kapsul',
                'jenis' => 'Generik',
                'stok' => 300,
                'harga' => 12000,
                'satuan' => 'strip',
            ],
        ]);
    }
}
