<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KunjunganSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('kunjungans')->insert([
            [
                'pasien_id' => 1,
                'dokter_id' => 1,
                'tanggal_kunjungan' => '2025-11-16 13:00:00',
                'keluhan' => 'Sakit Tenggorokan, muntah dan pusing',
                'diagnosa' => 'Asam Lambung dan Radang',
                'tindakan' => 'Pemberian obat',
                'biaya_kunjungan' => 100000,
                'status' => 'selesai',
            ],
        ]);
    }
}
